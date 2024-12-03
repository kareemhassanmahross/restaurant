<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class Customers extends Model
{
    /** @use HasFactory<\Database\Factories\CustomersFactory> */
    use HasFactory, Notifiable ,HasApiTokens;

    protected $fillable = [
       'name',
       'phone'
    ];
    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];
}
