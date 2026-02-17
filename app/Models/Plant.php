<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory; //Links eloquent model to its corresponding factory class
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    // This allows these fields to be mass assigned (Dealing with MassAssignment Exception)
    protected $fillable = [
        'nursery_id',
        'name',
        'category',
        'description',
        'price',
        'stock_quantity',
        'scientific_name',
        'sunlight_requirement',
        'water_requirement',
        'image',
    ];

    public function Nursery()
    {
        return $this->belongsTo(Nursery::class); //A plant belongs to a nursery.
    }
}
