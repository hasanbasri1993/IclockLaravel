<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'checkinout';

    protected $fillable = [
        'sn',
        'stamp',
        'employee_id',
        'checktime',
        'checktype',
        'verifycode',
        'sensorid',
        'WorkCode',
        'Reserved',
    ];

    protected $casts = [
        'checktime' => 'datetime',
    ];
}
