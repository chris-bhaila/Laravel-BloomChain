<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Exception;
use App\Models\Price;
use App\Models\Shoe;

     


class CookieController extends Controller
{
    // Cart content {new} Cookie ma add garna
    public function setCookie(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'price_id' => 'required',
                'size' => 'required'
            ]);

            $key = 'cart-' . (string) Uuid::uuid4();

            $data = [
                'price_id' => $request->query('price_id'),
                'size' => $request->query('size')
            ];

            $jsonData = json_encode($data);
            
            // Create cookie and return response
            $cookie = cookie()->make($key, $jsonData, 43200); // 30 days
            
            return response()->json([
                'success' => true,
                'message' => 'Successfully added to cart'
            ])->withCookie($cookie);
            
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 422);
        }
    }

    public function index(Request $request)
    {  
        $cartItems = [];
        $cookieNames = $request->cookies->keys();
        
        foreach ($cookieNames as $name) {
            if (strpos($name, 'cart-') === 0) {
                $requestData = $request->cookie($name);
                $jsonData = json_decode($requestData, true);
                
                if (json_last_error() === JSON_ERROR_NONE && isset($jsonData['price_id'])) {
                    $priceQuery = Price::find($jsonData['price_id']);
    
                    if ($priceQuery) {
                        $shoeQuery = Shoe::where('article_id', $priceQuery->article_id)->first();
    
                        if ($shoeQuery) {
                            $productGrouping = json_decode($priceQuery->product_grouping, true);
                            $cartItems[] = [
                                'key' => $name,
                                'price_id' => $priceQuery->price_id,
                                'shoe_name' => $shoeQuery->shoe_name,
                                'size' => $jsonData['size'],
                                'type' => is_array($productGrouping) ? array_values($productGrouping) : null,
                                'image' => "/assets/images/products/" . $priceQuery->article_id . "/" . $shoeQuery->shoe_image1,
                                'price' => $priceQuery->price,
                            ];
                        }
                    }
                }
            }
        }
    
        return response()->json([
            'cartItems' => $cartItems,
        ]);
    }


    public function updateCookie(Request $request, $cookieName)
    {
        $query_price_id = $request->query('price_id');
        $query_size = $request->query('size');
        $json_price_id = $request->cookie($cookieName);
        $cookieData = json_decode($json_price_id, true);
        $price_id = $cookieData['price_id'];
        $size = $cookieData['size'];
        if(!empty($query_size)){
            $size = $query_size;
        }
        if (!empty($query_price_id)) {
            $price_id = $query_price_id;
        }

        $data = [
            'price_id' => $price_id,
            'size' => $size
        ];

        $jsonData = json_encode($data);
        // Cookie::queue($cookieName, $jsonData, 43200);
        return response("Cookie '{$cookieName}' has been updated\n{$jsonData}")->cookie($cookieName, $jsonData, 43200);
    }

    // Chaldaina yo delete all wala (Himal le garxa)
    //All cookies delete garna FIXED
    public function deleteCookies(Request $request, $calledByController = false)
    {
        $cookieName = $request->cookies->keys();
        if (empty($cookieName)) {
            return response('No Cookies to Delete');
        }
        foreach ($cookieName as $name) {
            if (strpos($name, 'cart-') === 0){
                cookie()->queue(cookie()->forget($name));
            }
        }
        if($calledByController){
            return response('Product or Size is Unavailable So Cart was Cleared');
        }
        return response('All Cookies have been deleted');
    }

    public function deleteSingleCookie(Request $request, $cookie)
    {
        // Cookie::queue(Cookie::forget($cookie));
        return response("Cookie '{$cookie}' has been deleted")->withCookie(cookie()->forget($cookie));
    }
}
