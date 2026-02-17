<?php

namespace App\Services;


use App\Models\TemporaryOrder;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

class ESewaService
{
    protected $merchantId;
    protected $secretKey;
    protected $url;
    protected $statusUrl;

    public function __construct()
    {
        $this->merchantId = Config::get('esewa.merchant_id');
        $this->secretKey = Config::get('esewa.secret_key');
        $this->url = Config::get('esewa.url');
        $this->statusUrl = Config::get('esewa.status_url');
    }

    public function generateSignature($totalAmount, $transactionUuid, $productCode)
    {
        $data = "total_amount={$totalAmount},transaction_uuid={$transactionUuid},product_code={$productCode}";
        $signature = hash_hmac('sha256', $data, $this->secretKey, true);
        return base64_encode($signature);
    }

    public function processPayment($amount,
    $taxAmount,
    $totalAmount,
    $transactionUuid,
    $productCode,
    $successUrl,
    $failureUrl,
    $savedata = [],              
    $productServiceCharge = 0,
    $productDeliveryCharge = 0)
    {
        $signedFieldNames = "total_amount,transaction_uuid,product_code";
        $signature = $this->generateSignature($totalAmount, $transactionUuid, $productCode);
        $successUrlWithData = $successUrl . '?transaction_uuid=' . $transactionUuid;

        TemporaryOrder::create([
            'transaction_uuid' => $transactionUuid,
            'data' => json_encode($savedata), 
        ]);

        $formData = [
            'amount' => $amount,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'transaction_uuid' => $transactionUuid,
            'product_code' => $productCode,
            'product_service_charge' => $productServiceCharge,
            'product_delivery_charge' => $productDeliveryCharge,
            'success_url' => $successUrlWithData,
            'failure_url' => $failureUrl,
            'signed_field_names' => $signedFieldNames,
            'signature' => $signature,
        ];

                $form = '<form id="esewaPaymentForm" action="' . $this->url . '" method="POST">';
        foreach ($formData as $key => $value) {
            $form .= '<input type="hidden" name="' . $key . '" value="' . $value . '">';
        }
        $form .= '</form>';
        $form .= '<script>document.getElementById("esewaPaymentForm").submit();</script>';

        return $form;
    }

    public function verifyPayment($productCode, $totalAmount, $transactionUuid)
    {
        $client = new Client();
        try{
            $response = $client->get($this->statusUrl, [
                'query' => [
                    'product_code' => $productCode,
                    'total_amount' => $totalAmount,
                    'transaction_uuid' => $transactionUuid,
                ],
            ]);

            return json_decode($response->getBody(), true);
        }catch (\Exception $e){
            return redirect()->route('cart')->with('error', 'Failed Please Contact S.K. Shoes');
        }
    }
}