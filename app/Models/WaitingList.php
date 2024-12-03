<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaitingList extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'from_time',
        'to_time',
    ];

    protected $hidden = [
        'updated_at'
    ];
}
