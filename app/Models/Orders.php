<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    /** @use HasFactory<\Database\Factories\OrdersFactory> */
    use HasFactory;
    protected $fillable = [
        'table_id',
        'customer_id',
        'reservation_id',
        'waiter_id',
        'data',
        'total'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
