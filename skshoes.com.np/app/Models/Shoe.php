<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shoe extends Model
{

    protected $primaryKey = 'article_id';
    public $incrementing = false;
    public $keytype = 'string';

    protected $fillable = [
        'article_id',
        'shoe_name',
        'shoe_color',
        'shoe_image1',
        'shoe_image2',
        'shoe_image3',
        'shoe_image4',
        'shoe_image5',
        'shoe_image6',
        'shoe_video',
        'shoe_description',
        'category_name',
    ];
    public function prices()
    {
        return $this->hasMany(Price::class, 'article_id', 'article_id');
    }
    public function discounts()
    {
        return $this->hasMany(Discount::class, 'article_id', 'article_id');
    }
}
