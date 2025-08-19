<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class leave extends Model
{
    protected $fillable = [
        'types',
        'interval',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'description',
        'status',
        'additionalFile'
    ];
}