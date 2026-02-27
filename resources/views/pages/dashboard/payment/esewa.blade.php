<body onload="document.getElementById('esewa-form').submit()">
    <form id="esewa-form" action="{{ config('services.esewa.url') }}" method="POST">
        <input type="hidden" name="amount"           value="{{ $amount }}">
        <input type="hidden" name="tax_amount"       value="0">
        <input type="hidden" name="total_amount"     value="{{ $amount }}">
        <input type="hidden" name="transaction_uuid" value="{{ $transactionId }}">
        <input type="hidden" name="product_code"     value="{{ config('services.esewa.product_code') }}">
        <input type="hidden" name="product_service_charge" value="0">
        <input type="hidden" name="product_delivery_charge" value="0">
        <input type="hidden" name="success_url"      value="{{ route('esewa.verify') }}">
        <input type="hidden" name="failure_url"      value="{{ route('subscription') }}">
        <input type="hidden" name="signed_field_names" value="total_amount,transaction_uuid,product_code">
        <input type="hidden" name="signature"        value="{{ $signature }}">
    </form>
</body>