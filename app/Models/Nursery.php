<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Plant;

class Nursery extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'location',
        'description',
        'contact_phone',
        'contact_email',
        'is_active',
    ];

    public function plants()
    {
        return $this->hasMany(Plant::class);
    }
}
