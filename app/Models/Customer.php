<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
        use HasFactory;

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'repeat_type',
        'weekday',
        'time_of_day'
    ];
}
