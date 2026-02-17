<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{

    protected $primaryKey = 'category_name';
    public $incrementing = false;
    public $keyType = 'string';

    protected $fillable = [
        'category_name',
        'category_image',
        'feature',
    ];
    public $timestamps = false;

    public function discounts()
    {
        return $this->hasMany(Discount::class, 'category_name', 'category_name');
    }
    
    public function shoes()
    {
        return $this->hasMany(Shoe::class, 'category_name', 'category_name');
    }
}
