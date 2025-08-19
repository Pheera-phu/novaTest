<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'issue',
        'task',
        'project',
        'types',
        'status',
        'start_date',
        'end_date',
        'remark',
        'author',
        'testRound',
        'tester',
        'additionalFile'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];
}