<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Price;
use Exception;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $article_id = request()->query('article');
        $price_id = request()->query('price_id');

        // Default values to avoid undefined variables
        $formattedData = [];
        $stocks = [];
        $msg = [];

        try {
            if ($article_id) {
                $groupingQuery = Price::where('article_id', $article_id)->pluck('product_grouping', 'price_id');
    
                $formattedData = $groupingQuery->mapWithKeys(function ($grouping, $priceId) {
                    $decodedGrouping = json_decode($grouping, true);
                    return [$priceId => is_array($decodedGrouping) ? $decodedGrouping : []];
                })->toArray();
                if ($price_id) {
                    $stocks = Stock::with('price')
                        ->where('price_id', $price_id)
                        ->get()
                        ->map(function ($stock) {
                            return [
                                'id' => $stock->id,
                                'size' => $stock->size,
                                'stock' => $stock->stock,
                                'product_grouping' => json_decode($stock->price->product_grouping, true)?? null,
                            ];
                        });
                }
            }
            
        } catch (\Throwable $th) {
            $msg = ['error' => $th->getMessage()];
        }


        // Pass both $formattedData and $stocks to the view
        return view('admin.stocks', [
            'formattedData' => $formattedData,
            'stocks' => $stocks,
            'msg' => $msg
        ]);
    }


    /**Adding Stock FOR ADMIN PART */
    public function store(Request $request){
    $price_id = $request->input('price_id');
    $size = $request->input('size');
        try{
            Stock::create([
                'price_id' => $price_id,
                'size' => $size,
                'stock' => '0',
            ]);

            return redirect()->back()->with('success', 'Successfully added the stock');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to add the stock: ' . $e->getMessage());
        }    
    }

    /**Editing Stock FOR ADMIN PART */
    public function update($stock_id, Request $request)
    {
        $stock = $request->input('stock');  

        try {
            $existingStock = Stock::find($stock_id);

            if (!$existingStock) {
                return response()->json(['success' => false, 'message' => 'Stock Not Found'], 404);
            }
            $existingStock->update([
                'stock' => $stock,
            ]);

            return response()->json(['success' => true, 'message' => 'Successfully updated the stock']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

   //Deleting Stock
   public function destroy($id)
   {
       $stock = Stock::find($id);
       if (!$stock) {
           return response()->json(['success' => false, 'message' => 'Stock not found'], 404);
       }

       try {
           $stock->delete();
           return response()->json(['success' => true, 'message' => 'Deletion successful']);
       } catch (Exception $e) {
           return response()->json(['success' => false, 'message' => 'Error deleting stock: ' . $e->getMessage()], 500);
       }
   }
}
