<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceLog extends Model
{
    protected $table = 'devlogs';

    protected $fillable = [
        'SN',
        'Object',
        'Cnt',
        'OP',
        'ECnt',
        'OpTime',
    ];
}
