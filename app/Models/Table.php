<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    /** @use HasFactory<\Database\Factories\TableFactory> */
    use HasFactory;
    protected $fillable = ['capacity'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
