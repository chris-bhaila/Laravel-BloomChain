<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemporaryOrder extends Model
{
    protected $primaryKey = 'transaction_uuid';
    
    protected $fillable = [
        'transaction_uuid',
        'data',
    ];
}
