<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Category;
use App\Models\Price;
use App\Models\Shoe;
use Exception;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    //For Customer When Discount Code in inputed
    public function discountcheck(Request $request){
        $price_id = $request->query('price_id');
        $discount_code = $request->query('discount_code');

        try{
            $pricequery = Price::where('price_id', $price_id)->firstOrFail();
            $shoequery = Shoe::where('article_id', $pricequery->article_id)->firstOrFail();
            $query = Discount::where('discount_code', $discount_code)->firstOrFail();
        }
        catch(Exception $e){
            return response()->json(['error' => 'Invalid Discount Code']);

        }

        $currentDate = now();
        if (($query->expiry_date < $currentDate)||($query->maximum_use <= $query->use_count)){
            $query->status = 'inactive';
            $query->save();
        }

        $output = ['success' => 'Not a applicable discount'];

        
        if (($query->status == 'active' && $pricequery->article_id == $query->article_id)||
            ($query->status == 'active' && ($query->category_name == $shoequery->category_name || $query->category_name == "all"))){

            $discount_amount = $pricequery->price *( $query->percentage /100);

            if($discount_amount > $query->maximum_amount){
                $discount_amount = $query->maximum_amount;
            }
            $discounted_price = $pricequery->price - $discount_amount;

            $output = [
                'Discounted' => [
                    'discounted_price' => $discounted_price,
                    'percentage' => $query->percentage.'%',
                ]
            ];
        }
             
        return response()->json($output);

    }
    public function index(Request $request)
    {
        try {
            $discounts = Discount::all(); 
            $categories  = Category::all();
            $edit = null;
            if($request->has('editing'))
            {
                $edit = Discount::where('discount_code', $request->query('editing'))->first();
            }

            return view("admin.discount", [
                    'discounts' => $discounts,
                    'categories' => $categories,
                    'edit' => $edit,
                ] 
            );
            
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
    

    //Storing Discount Data
    public function store(Request $request)
    {
        try {
            $request->validate([
                'discount_code' => 'required',
                'percentage' => 'required|numeric',
                'maximum_use' => 'required|numeric',
                'maximum_amount' => 'required|numeric',
                'expiry_date' => 'required|date',
            ]);
            
            $category_name = $request->category_name ?? Null;
            $article_id = $request->article_id ?? Null;
            
            if($category_name == Null && $article_id == Null){
                return response()->json(['error' => 'Please select either category or article'], 400);
            }

            if($category_name == 'all'){
                $category_name = $article_id = NULL;
            }
            try{
                $discount = Discount::create([
                    'discount_code' => $request->discount_code,
                    'percentage' => $request->percentage,
                    'maximum_use' => $request->maximum_use,
                    'use_count' => 0,
                    'maximum_amount' => $request->maximum_amount,
                    'expiry_date' => $request->expiry_date,
                    'article_id' => $article_id,
                    'category_name' => $category_name,
                    'status' => 'active'
                ]);
            }catch(Exception $e){
                return response()->json(['error' => 'Something Went wrong probably invalid article Id'], 400);
            }

            return response()->json(["success" => "Discount Updated Successfully"]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //Article Search Component
        public function articleSearch(Request $request)
    {
        $article_id = $request->query('shoe'); // Using query() instead of input()

        $shoeQuery = Shoe::where('article_id', 'LIKE', "%{$article_id}%")
            ->limit(10)
            ->pluck('article_id');

        return response()->json($shoeQuery);
    }

    //Update Discount Admin Side
    public function update($discount_code, Request $request)
    {
        $percentage = $request->input('percentage', null);
        $maximum_use = $request->input('maximum_use', null);
        $maximum_amount = $request->input('maximum_amount', null);
        $expiry_date = $request->input('expiry_date', null);
        $article_id = $request->input('article_id', null);
        $category_name = $request->input('category_name', null);
        $status = $request->input('status', null);

        if($status == NULL){
            if($category_name == Null && $article_id == Null){
                return response()->json(['error' => 'Please select either category or article'], 400);
            }
        }
        try{  
            $discountQuery = Discount::where('discount_code', $discount_code)->firstOrFail();     
            if($percentage){
                $discountQuery->percentage = $percentage;
            }
            if($maximum_use){
                $discountQuery->maximum_use = $maximum_use;
            }
            if($maximum_amount){
                $discountQuery->maximum_amount = $maximum_amount;
            }
            if($expiry_date){
                $discountQuery->expiry_date = $expiry_date;
            }
            if($article_id == 'all' & $category_name == 'all'){
                $discountQuery->article_id = null;
                $discountQuery->category_name = null;
            }else{
                if($article_id){
                    $discountQuery->article_id = $article_id;
                    $discountQuery->category_name = null;
                }
                if($category_name){
                    $discountQuery->category_name = $category_name === 'all' ? null : $category_name;
                    $discountQuery->article_id = null;
                }
            }
            if($status){
                $discountQuery->status = $status;
            }
            $discountQuery->save();
            return response()->json(["success" => "Discount Updated Successfully"]);
        }catch(Exception $e){
            return response()->json(['error' => "Something went wrong Probablly invalid Article Id"], 500);
        }
        
    }

    //Deliting Discount Admin Side
    public function destroy($discount_code)
    {
        try {
            $discount = Discount::where('discount_code', $discount_code)->firstOrFail();
            $discount->delete();
    
            return response()->json(["success" => "Discount deleted successfully"]);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }
}