<?php

namespace App\Http\Controllers;

use App\Services\EsewaService;
use Illuminate\Http\Request;
use App\Models\TemporaryOrder;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;


class PaymentController extends Controller
{
    public function esewaSuccess(Request $request)
    {
        $esewaService = new ESewaService();
        $productCode = config('esewa.merchant_id');

        
        $transactionUuidWithData = $request->input('transaction_uuid');
        $transactionUuidParts = explode('?', $transactionUuidWithData);
        $transactionUuid = head($transactionUuidParts);

        $orderData = TemporaryOrder::where('transaction_uuid', $transactionUuid)->firstorFail();
        $orderData = json_decode($orderData->data, true);
        $totalAmount = $orderData['price'];

        $verification = $esewaService->verifyPayment($productCode, $totalAmount, $transactionUuid);

        if (isset($verification['status']) && $verification['status'] == 'COMPLETE') {
            
            $orderData['transaction_uuid'] = (string) Str::uuid();
            app(OrderController::class)->store($orderData);
            session()->forget(['esewa_transaction_uuid', 'pending_order_data']);

            $response = $this->calldelete(request());
            return redirect()->route('cart')->with('success', 'Order Added Sucessfully');
        } else {
            session()->forget(['esewa_transaction_uuid', 'pending_order_data']);
            return redirect()->route('cart')->with('error', 'Failed Please Contact S.K. Shoes');
        }
    }
    public function calldelete(Request $request){
        $response = app(CookieController::class)->deleteCookies($request, true);
            foreach (Cookie::getQueuedCookies() as $cookie) {
                $response->withCookie($cookie);
            }
            return $response;
    }

    public function failure(Request $request)
    {
        session()->forget(['esewa_transaction_uuid', 'pending_order_data']);
        return redirect()->route('cart')->with('error', 'Failed Please Contact S.K. Shoes');
    }
}