<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $primaryKey = 'SN';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'SN',
        'State',
        'LastActivity',
        'TransTimes',
        'TransInterval',
        'LogStamp',
        'OpLogStamp',
        'PhotoStamp',
        'Alias',
        'DeptID',
        'UpdateDB',
        'Style',
        'FWVersion',
        'FPCount',
        'TransactionCount',
        'UserCount',
        'MainTime',
        'MaxFingerCount',
        'MaxAttLogCount',
        'DeviceName',
        'AlgVer',
        'FlashSize',
        'FreeFlashSize',
        'Language',
        'VOLUME',
        'DtFmt',
        'IPAddress',
        'IsTFT',
        'Platform',
        'Brightness',
        'BackupDev',
        'OEMVendor',
        'City',
        'AccFun',
        'TZAdj',
        'DelTag',
        'FPVersion',
        'PushVersion',
    ];
}
