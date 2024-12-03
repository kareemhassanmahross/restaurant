<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{
    /** @use HasFactory<\Database\Factories\ReservationsFactory> */
    use HasFactory;
    protected $fillable = [
        'table_id',
        'from_time',
        'to_time',
        'customer_id',
    ];
}
