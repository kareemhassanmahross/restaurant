<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Details extends Model
{
    /** @use HasFactory<\Database\Factories\OrderDetailsFactory> */
    use HasFactory;
    protected $fillable = [
        'order_id',
        'meal_id',
        'amount_to_pay',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
