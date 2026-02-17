<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Price extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'price_id';
    
    protected $fillable = [
        'article_id',
        'product_grouping',
        'price',
    ];
    public function stocks()
    {
        return $this->hasMany(Stock::class, 'price_id', 'price_id');
    }
}
