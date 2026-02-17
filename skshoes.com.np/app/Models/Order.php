<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';
    
    protected $fillable =[
        'order_id',
        'customer_name',
        'article_id',
        'shoe_name',
        'product_grouping',
        'size',
        'address',
        'nearest_landmark',
        'phone_number',
        'email',
        'status',
        'price',
        'discount_code',
        'discounted_price',
        'payment_method',
        'transactionId',
        'status',
    ];
}
