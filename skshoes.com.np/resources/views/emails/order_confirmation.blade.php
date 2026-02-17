<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
</head>
<body>
    <h1>Thank you for your order, {{ $order['customer_name'] }}</h1>
    <p>Your order has been received and is being processed.</p>

    <h2>Order ID: {{ $order['orderId'] }}</h2>
    <p><strong>Order Status:</strong> {{ $order['status'] }}</p>
    <p><strong>Email:</strong> {{ $order['email'] }}</p>
    <p><strong>Address:</strong> {{ $order['address'] }}, {{ $order['nearest_landmark'] }}</p>
    <p><strong>Phone Number:</strong> {{ $order['phone_number'] }}</p>


    <h3>Items:</h3>
    <ul>
        @foreach ($order['items'] as $item)
            <li>
                <strong>Shoe:</strong> {{ $item['shoe_name'] }},
                <strong>Size:</strong> {{ $item['size'] }},
                <strong>Price:</strong> RS:{{ $item['price'] }}
            </li>
        @endforeach
        
    </ul>

    <p><strong>Order Total (INCLUDING Delivery):</strong> RS: {{ $order['order_total'] }}</p>

    @if($order['payment_method'] == 'cod')
        <p><strong>TO BE PAID DURING DELIVERY</strong></p>
    @else
        <p><strong>PAID VIA:</strong> {{ $order['payment_method'] }}</p>
        <p><strong>Transaction ID:</strong> {{ $order['transactionId'] ?? 'Only Available when using PrePayment Methods' }}</p>
    @endif
    
     @if($order['discount_code'])
        <p><strong>Discount Code:</strong> {{ $order['discount_code'] }}</p>
     @endif
      @if($order['discounted_price'])
         <p><strong>Discounted Price:</strong> ${{ $order['discounted_price'] }}</p>
      @endif

    <p>IF YOU WOULD LIKE TO CANCEL ORDER OR REPORT ANY ISSUE CONTACT: 985998149, 9823709835</p>
</body>
</html>