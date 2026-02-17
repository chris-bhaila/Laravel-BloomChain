<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $primaryKey = 'discount_code';
    public $incrementing = false;
    public $keytype = 'string';
    public $timestamps = false;

    protected $fillable =[
        'discount_code',
        'percentage',
        'maximum_use',
        'use_count',
        'maximum_amount',
        'expiry_date',
        'article_id',
        'category_name',
        'status'
    ];
}
