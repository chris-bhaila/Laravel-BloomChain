<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'transaction_id',
        'plan',
        'amount',
        'payment_method',
        'status',
        'renewal_at',
    ];

    protected $casts = [
        'renewal_at' => 'datetime', //turns renewal_at into a imitation of carbon_instance, created as a string during migration
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
