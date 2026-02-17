<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Price;
use App\Models\Discount;
use App\Models\Stock;
use App\Models\Shoe;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use App\Services\EsewaService;
use App\Mail\OrderConfirmationEmail;
use Illuminate\Support\Facades\Mail;




class OrderController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Order::orderBy('created_at', 'desc');

            if ($request->has('timeFrame')) {
                $filter = $request->query('timeFrame');
                switch ($filter) {
                    case '12months':
                        $query->where('created_at', '>=', Carbon::now()->subMonths(12));
                        break;
                    case '30days':
                        $query->where('created_at', '>=', Carbon::now()->subDays(30));
                        break;
                    case '7days':
                        $query->where('created_at', '>=', Carbon::now()->subDays(7));
                        break;
                    case '24hours':
                        $query->where('created_at', '>=', Carbon::now()->subHours(24));
                        break;
                }
            }

            if ($request->has('fromDate') && $request->has('toDate')) {
                $fromDate = Carbon::parse($request->query('fromDate'))->startOfDay();
                $toDate = Carbon::parse($request->query('to_date'))->endOfDay();
                $query->whereBetween('created_at', [$fromDate, $toDate]);
            }

            if ($request->has('status') && $request->query('status') !== '') {
                $statuses = explode(',', $request->query('status'));
                $query->whereIn('status', $statuses);

            }

            if ($request->has('orderId') && $request->query('orderId') !== '') {
                $query->where('order_id', $request->query('orderId'));

            }

            if ($request->has('articleId') && $request->query('articleId') !== '') {
                $query->where('article_id', 'LIKE', '%' . $request->query('articleId') . '%');
            }

            if ($request->has('customerName') && $request->query('customerName') !== '') {
                $query->where('customer_name', 'LIKE', '%' . $request->query('customerName') . '%');
            }

            $orders = $query->paginate(40);
            
            $filter = [
                'selectedFilter' => $request->query('timeFrame'),
                'fromDate' => $request->query('fromDate'),
                'toDate' => $request->query('toDate'),
                'selectedStatus' => $request->query('status'),
                'orderID' => $request->query('orderId'),
                'articleID' => $request->query('articleId'),
                'customerName' => $request->query('customerName'),
            ];
            foreach ($orders as $order) {
                if ($order->price == 0) {
                    $order->price = "SAME CART";
                }
            }
    
            
            return view('admin.orders', ['orders' => $orders, 'filter' => $filter]);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    //Individual Order Details For Admin
    public function show($order_id)
    {
        try {
            $orderQuery = Order::where('order_id', $order_id)->firstOrFail();
            $imageQuery = Shoe::where('article_id', $orderQuery->article_id)->select('article_id','shoe_color','category_name','shoe_image1')->first();
            try {
                $category = Shoe::where('article_id', $orderQuery->article_id)->value('category');
            } catch (Exception $e) {
                $category = null;
            }
            $grouping = [];
            $groupingData = $orderQuery->product_grouping;

            // If it's not already an array, decode it.
            if (!is_array($groupingData)) {
                $groupingData = json_decode($groupingData, true);
            }

            $grouping = [];
            if (!empty($groupingData) && is_array($groupingData)) {
                foreach ($groupingData as $key => $value) {
                    $grouping[] = ['key' => $key, 'value' => $value];
                }
            }
            $order = [
                'id' => $order_id,
                'customer_name' => $orderQuery->customer_name,
                'article_id' => $orderQuery->article_id,
                'product' => $orderQuery->shoe_name,
                'category' => $category->category_name ?? "Undefined",
                'grouping' => $grouping,
                'size' => $orderQuery->size,
                'address' => $orderQuery->address,
                'nearest_mark' => $orderQuery->nearest_landmark,
                'phone_number' => $orderQuery->phone_number,
                'email' => $orderQuery->email,
                'status' => $orderQuery->status,
                'total_amount' => ($orderQuery->price == 0) ? "Same Cart" : $orderQuery->price,
                'discount_code' => $orderQuery->discount_code,
                'discounted_amount' => $orderQuery->discounted_price,
                "payment_method" => $orderQuery->payment_method,
                'ordered_at' => $orderQuery->created_at,
                'confirmed_at' => $orderQuery->updated_at,
                'category'=> $imageQuery->category_name ?? "Undefined",
                'shoe_color'=> $imageQuery->shoe_color ?? "Undefined",
                'product_image' => $imageQuery && $imageQuery->shoe_image1 
                    ? "/assets/images/products/" . $imageQuery->article_id . "/" . $imageQuery->shoe_image1 
                    : null,
                'color' => $imageQuery->shoe_color ?? "Undefined",
                'transactionId' => $orderQuery->transactionId,
            ];
            return view('admin.order-details', [
                'order' => (object) $order,
            ]);
        } catch (Exception $e) {
            return
                view('admin.order-details', ['order' => null, 'error' => $e->getMessage()]);
        }
    }

    //Order Validation
    public function checkout(Request $request)
    {
        $validatedData = $request->validate([
            'price_id' => 'required|json',
            'city' => 'required',
            'customer_name' => 'required',
            'address' => 'required',
            'nearest_landmark' => 'required',
            'email' => 'required|email', 
            'phone_number' => 'required|digits_between:7,15',
            'method' => 'required'
        ]);
        

        $items = json_decode($validatedData['price_id'], true);
        if ($items === null && json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid JSON format in items']);
        }

        $city = $validatedData['city'];
        $customer_name = $validatedData['customer_name'];
        $address = $validatedData['address'];
        $discount_code =  $request->input('discount_code', null);
        $nearest_landmark = $validatedData['nearest_landmark'];
        $email = $validatedData['email'];
        $phone_number = $validatedData['phone_number'];
        $method = $validatedData['method'];

        //COPIED FROM CARTCONTROLLER
        $shippingCost = 0;
        $cityData = collect(json_decode(file_get_contents(storage_path('app/private/cityPrice.json')), true)['City']);
        $shippingCost = $cityData->where('name', $city)->pluck('charge')->first() ?? 0;
        $totalPrice = 0;
        $totalDiscount = 0;
        $itemCount = 0;

        if (!$shippingCost) {
                return response()->json(['error' => 'Error!']);
        }
        if($discount_code){
            $discountQuery = Discount::where('discount_code', $discount_code)->first();
                if(!$discountQuery){
                    return response()->json(['error' => 'Invalid or ']);
                }
        }

        try {
            foreach ($items as $item) {
                $price_id = $item['price_id'];
                $size = $item['size'];
                $itemCount++;

                $priceQuery = Price::where('price_id', $price_id)->first();
                $stockQuery = Stock::where('price_id', $price_id)->where('size', $size)->first();
                if ($priceQuery) {
                    $shoeQuery = Shoe::where('article_id', $priceQuery->article_id)->first();
                } else {
                    return response()->json(["error" => "Price Not Found"]);
                }

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

        $finalTotal = $totalPrice - $totalDiscount + ($shippingCost * $itemCount);

        $data = [
            'items' => $items,
            'customer_name' => $customer_name,
            'address' => $address,
            'nearest_landmark' => $nearest_landmark,
            'phone_number' => $phone_number,
            'email' => $email,
            'discount_code' => $discount_code,
            'discounted_price' => $totalDiscount,
            'payment_method' => $method,
            'price' => $finalTotal,
        ];

        if($method == "cod"){
            return $this->store($data); 
        }
        if($method == "esewa"){
            $esewaService = new ESewaService();
            $transactionUuid = uniqid();
            $productCode = config('esewa.merchant_id');
            $successUrl = route('payment.esewa.success');
            $failureUrl = route('payment.failure');
            $amount = $finalTotal;
            $taxAmount = 0;
            $totalAmount = $finalTotal;
            
            $esewaForm = $esewaService->processPayment(
                $amount,
                $taxAmount,
                $totalAmount,
                $transactionUuid,
                $productCode,
                $successUrl,
                $failureUrl,
                $savedata = $data,
                0, 
                0 
            );
            
            return $esewaForm;
        }
        return response()->json(['error' => 'Invalid payment method'], 400);
    }
    
    
    //Order Storage
    public function store(array $data)
    {
        $items = $data['items'];
        $transactionUuid = $data['transaction_uuid'] ?? null;
        $orderTotal = 0;
        $priceStored = false;
        foreach ($items as $item) {
            $price_id = $item['price_id'];
            $size = $item['size'];
            $discount_code = $data['discount_code'] ?? null;

            $priceQuery = Price::where('price_id', $price_id)->select('article_id', 'product_grouping', 'price')->first();
            if (!$priceQuery) {
                return response()->json(['error' => 'Price ID not found: ' . $price_id], 404);
            }
            $shoeQuery = Shoe::where('article_id', $priceQuery->article_id)->select('shoe_name')->first();
            if (!$shoeQuery) {
                return response()->json(['error' => 'Shoe not found for article ID: ' . $priceQuery->article_id], 404);
            }


            try {
                DB::beginTransaction();

                $order = new Order();
                $order->customer_name = $data['customer_name'];
                $order->article_id = $priceQuery->article_id;
                $order->shoe_name = $shoeQuery->shoe_name;
                $order->product_grouping = $priceQuery->product_grouping;
                $order->size = $size;
                $order->address = $data['address'];
                $order->nearest_landmark = $data['nearest_landmark'];
                $order->phone_number = $data['phone_number'];
                $order->email = $data['email'];
                $order->status = 'Received';
                $order->price =  $priceStored ? "0" : $data['price'];;
                $order->discount_code = $discount_code;
                $order->discounted_price = $data['discounted_price']?? null;
                $order->payment_method = $data['payment_method'];
                $order->transactionId = $transactionUuid;
                $order->save();
                $orderId = $order->order_id;

                $stockQuery = Stock::where('price_id', $price_id)->where('size', $size)->firstOrFail();
                $stockQuery->stock = $stockQuery->stock - 1;
                $stockQuery->save();

                if($discount_code){
                    $discountQuery = Discount::where('discount_code', $discount_code)->firstOrFail();
                    $discountQuery->use_count = $discountQuery->use_count + 1;
                    $discountQuery->save();
                }

                DB::commit();    

            } catch (Exception $e) {
                DB::rollBack();
                return response()->json(['error' => $e->getMessage()]);
            }
            $priceStored = true;
             // Prepare data for the email
            $orderItems[] = [
                'shoe_name' => $shoeQuery->shoe_name,
                'size'      => $size,
                'price'     => $priceQuery->price, // Use the price from the database
            ];
            $orderTotal = $data['price']; 
        }
        $orderData = [
            'orderId' => $orderId,
            'customer_name' => $data['customer_name'],
            'email'         => $data['email'],
            'address'       => $data['address'],
            'nearest_landmark'=> $data['nearest_landmark'],
            'phone_number'  => $data['phone_number'],
            'items'         => $orderItems,
            'order_total'   => $orderTotal, // Pass the total
            'status'        => 'Received',
            'discount_code' => $data['discount_code'] ?? null,
            'discounted_price' => $data['discounted_price'] ?? null,
            'payment_method' => $data['payment_method'],
            'transactionId' => $transactionUuid ?? null,
            
    
        ];
    
        // Send the email
        Mail::to($data['email'])->send(new OrderConfirmationEmail($orderData));
        $response = $this->calldelete(request()); // Pass the request object

        return redirect()->route('cart')->with('success', 'Order Added Successfully')->withHeaders($response->headers->all());
    }
    public function calldelete(Request $request){
        $response = app(CookieController::class)->deleteCookies($request, true);
            foreach (Cookie::getQueuedCookies() as $cookie) {
                $response->withCookie($cookie);
            }
            return $response;
    }

        //Admin Side Updating Order
        public function update($order_id, Request $request)
    {
        $currentStatus = $request->input('currentStatus');
        $status = $request->input('status');
        $stock = null;
        try {
            $orderQuery = Order::where('order_id', $order_id)->firstOrFail();

            if (($status == "Returned" || $status == "Rejected") && $currentStatus != "Returned") {                try {
                    $price_id = Price::where('article_id', $orderQuery->article_id)
                    ->where('product_grouping', $orderQuery->product_grouping)
                    ->value('price_id');
                    $stockQuery = Stock::where('price_id', $price_id)->where('size', $orderQuery->size)
                        ->firstOrFail();
                            $stockQuery->stock += 1;
                            $stockQuery->save();
                } catch (Exception $e) {
                    $stock = "NotUpdated";
                }
            }
            if (($currentStatus == "Returned") && ($status != "Returned" && $status != "Rejected")){
            try{
                $price_id = Price::where('article_id', $orderQuery->article_id)
                    ->where('product_grouping', $orderQuery->product_grouping)
                    ->value('price_id');
                    $stockQuery = Stock::where('price_id', $price_id)->where('size', $orderQuery->size)
                        ->firstOrFail();
                            $stockQuery->stock -= 1;
                            $stockQuery->save();
                } catch (Exception $e) {
                    $stock = "NotUpdated";
                }    
            }        
    

            if ($status == "Rejected") {
                $orderQuery->delete();

                if ($stock == "NotUpdated") {
                    return response()->json(["error" => "IMPORTANT Order Was Updated but stock not updated"], 200);
                }

                return response()->json(["success" => "Order deleted successfully"], 200);
            }

            $orderQuery->status = $status;
            $orderQuery->save();

            if ($stock == "NotUpdated") {
                return response()->json(["error" => "Order status updated but stock not updated"], 200);
            }

            return response()->json(["success" => "Order updated successfully"], 200);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

}
