<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Price;
use App\Models\Discount;
use App\Models\Stock;
use App\Models\Shoe;
use Exception;
use Illuminate\Support\Facades\Cookie;


class CartController extends Controller
{
    public function index(Request $request)
    {
        $items = json_decode($request->query('price_id'), true);
        $city = $request->query('city', null);
        $discount_code = $request->query('discount', null);
        $totalPrice = 0;
        $totalDiscount = 0;
        $shippingCost = 0;
        $newShippingCost = 0;
        $itemCount = 0;

        if($items === null){
            return response()->json(['error' => 'No items provided in the cart.']);
        }

        if ($city) {
            $cityData = collect(json_decode(file_get_contents(storage_path('app/private/cityPrice.json')), true)['City']);
            $shippingCost = $cityData->where('name', $city)->pluck('charge')->first() ?? 0;

            if (!$shippingCost) {
                return response()->json(['error' => 'Please select another city which is near you!']);
            }
            $newShippingCost = $shippingCost;
        }
        if($discount_code){
            $discountQuery = Discount::where('discount_code', $discount_code)->first();
            if(!$discountQuery){
                $message = "Invalid Discount Code";
            }
        }

        try {
            foreach ($items as $item) {
                $price_id = $item['price_id'];
                $size = $item['size'];
                $itemCount++;

                $priceQuery = Price::where('price_id', $price_id)->firstOrFail();
                $stockQuery = Stock::where('price_id', $price_id)->where('size', $size)->firstOrFail();
                $shoeQuery = Shoe::where('article_id', $priceQuery->article_id)->firstOrFail();

                if ($stockQuery->stock == 0 || $stockQuery->stock == null) {
                    $response = app(CookieController::class)->deleteCookies($request, true);
                    foreach (Cookie::getQueuedCookies() as $cookie) {
                        $response->withCookie($cookie);
                    }
                    return $response;
                }

                $original_price = $priceQuery->price;
                $discount_amount = 0;

                if ($discount_code) {
                    $discountQuery = Discount::where('discount_code', $discount_code)->first();

                    if ($discountQuery && $discountQuery->status == 'active') {
                        if (
                            ($priceQuery->article_id == $discountQuery->article_id) ||
                            ($discountQuery->category_name == $shoeQuery->category_name) ||
                            ($discountQuery->category_name == null && $discountQuery->article_id == null)
                        ) {
                            $discount_amount = min(
                                $original_price * ($discountQuery->percentage / 100),
                                $discountQuery->maximum_amount
                            );
                        }
                    }
                }

                $discounted_price = $original_price - $discount_amount;
                $totalPrice += $discounted_price;
                $totalDiscount += $discount_amount;
            }
        } catch (Exception $e) {
            $response = app(CookieController::class)->deleteCookies($request, true);
            foreach (Cookie::getQueuedCookies() as $cookie) {
                $response->withCookie($cookie);
            }
            return $response;
        }
        if($discount_code && $totalDiscount == 0){
            $message = "Discount Not Applicable for the selected items";
        }

        $finalTotal = $totalPrice + ($newShippingCost * $itemCount);

        return response()->json([
            'subTotal' => $totalPrice,
            'discount' => $totalDiscount,
            'shipping' => $newShippingCost * $itemCount,
            'total' => $finalTotal - $totalDiscount,
            'message' => $message ?? null,
        ]);
    }

}
