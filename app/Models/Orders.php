<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'price',
        'credits',
        'discount_price',
        'payment_gateway',
        'transaction_id',
        'status'
    ];
}
