<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
 
    public $timestamps = false;
    protected $fillable = [
        'price_id',
        'size',
        'stock',
    ];

    public function price()
    {
        return $this->belongsTo(Price::class, 'price_id', 'price_id');
    }
}
