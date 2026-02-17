<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Stock;
use App\Models\Shoe;
use Exception;
use Illuminate\Http\Request;


class PriceController extends Controller
{ 
    //Customer Side Individual Products
    public function index($article_id)
    {
        try {
            $shoeQuery = Shoe::where('article_id', $article_id)->first();
            if (!$shoeQuery) {
                return redirect()->route('customer.home')->with('error', 'Product Not Found');
            }
            preg_match('/^(\d+)_/', $article_id, $matches);
            $articlePrefix = $matches[1] ?? null;

            if (!$articlePrefix) {
                return redirect()->route('customer.home')->with('error', 'Invalid article ID format');

            }
            $relatedShoes = Shoe::where('article_id', 'LIKE', "{$articlePrefix}_%")
                ->get(['article_id', 'shoe_color', 'shoe_image1']);

            $similarShoes = Shoe::where('category_name', $shoeQuery->category_name)->where('article_id', '!=', $article_id)->take(7)
                ->get(['article_id','shoe_name','shoe_color', 'shoe_image1'])->map(function ($shoe) {
                    $shoe->lowest_price = Price::where('article_id', $shoe->article_id)
                        ->orderBy('price', 'asc')
                        ->value('price');
                    return $shoe;
                });
            $priceQuery = Price::where('article_id', $article_id)->get();
            if ($priceQuery->isEmpty()) {
                return redirect()->route('customer.home')->with('error', 'No prices found for this article_id.');

            }

            $stockQuery = Stock::whereIn('price_id', $priceQuery->pluck('price_id'))->get(['price_id', 'size', 'stock']);

            $stockByPrice = $stockQuery->groupBy('price_id');

            $productGrouping = $priceQuery->mapWithKeys(function ($price) {
                return [$price->price_id => json_decode($price->product_grouping, true)];
            });

            $images = array_filter([
                $shoeQuery->shoe_image1 ? "/assets/images/products/{$shoeQuery->article_id}/{$shoeQuery->shoe_image1}" : null,
                $shoeQuery->shoe_image2 ? "/assets/images/products/{$shoeQuery->article_id}/{$shoeQuery->shoe_image2}" : null,
                $shoeQuery->shoe_image3 ? "/assets/images/products/{$shoeQuery->article_id}/{$shoeQuery->shoe_image3}" : null,
                $shoeQuery->shoe_image4 ? "/assets/images/products/{$shoeQuery->article_id}/{$shoeQuery->shoe_image4}" : null,
                $shoeQuery->shoe_image5 ? "/assets/images/products/{$shoeQuery->article_id}/{$shoeQuery->shoe_image5}" : null,
                $shoeQuery->shoe_image6 ? "/assets/images/products/{$shoeQuery->article_id}/{$shoeQuery->shoe_image6}" : null,
            ], 
            function ($value) {
                return $value !== null;
            });

            $response = [
                "shoes" => [
                    "article_id" => $shoeQuery->article_id,
                    "shoe_name" => $shoeQuery->shoe_name,
                    "shoe_color" => $shoeQuery->shoe_color,
                    "shoe_description" => $shoeQuery->shoe_description,
                    "category_name" => $shoeQuery->category_name,
                    "created_at" => $shoeQuery->created_at->toIso8601String(),
                    "updated_at" => $shoeQuery->updated_at->toIso8601String(),
                ],
                "prices" => $priceQuery->map(function ($price) {
                    return [
                        "price_id" => $price->price_id,
                        "article_id" => $price->article_id,
                        "price" => $price->price,
                    ];
                }),
                "product_grouping" => $productGrouping,
                "stock_details" => $stockByPrice->isNotEmpty() ? $stockByPrice->mapWithKeys(function ($stock, $price_id) {
                    return [
                        $price_id => $stock->sortBy('size')->values()->map(function ($item) {
                            return [
                                "size" => $item->size,
                                "stock" => $item->stock,
                            ];
                        }),
                    ];
                }): null,
                "images" => array_values($images),
                "video" => $shoeQuery->shoe_video ? "/assets/images/products/{$shoeQuery->article_id}/{$shoeQuery->shoe_video}" : null,
                "colours" => $relatedShoes->isNotEmpty() ? $relatedShoes->map(function ($shoe) {
                    return [
                        "article_id" => $shoe->article_id,
                        "shoe_color" => $shoe->shoe_color,
                        "shoe_image1" => $shoe->shoe_image1 ? "/assets/images/products/{$shoe->article_id}/{$shoe->shoe_image1}" : null,
                    ];
                }) : null,

                "similar" => $similarShoes->map(function ($shoe) {
                return [
                    "article_id" => $shoe->article_id,
                    "shoe_name" => $shoe->shoe_name,
                    "shoe_color" => $shoe->shoe_color,
                    "shoe_image" => $shoe->shoe_image1 ? "/assets/images/products/{$shoe->article_id}/{$shoe->shoe_image1}" : null,
                    "price" => $shoe->lowest_price,
                ];}),
            ];
            return view("customer.product-detail", ['product' => $response]);
            // return response()->json($response);

        } catch (Exception $e) {
            return redirect()->route('customer.home')->with('error', $e->getMessage());
        }
    }
}
