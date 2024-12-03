<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meals extends Model
{
    /** @use HasFactory<\Database\Factories\MealsFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'description',
        'quantity_available',
        'discount'
    ];
    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];
}
