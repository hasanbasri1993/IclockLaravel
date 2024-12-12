<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceCmd extends Model
{
    protected $table = 'device_cmds';

    protected $fillable = [
        'SN',
        'user_id',
        'CmdOrder',
        'CmdContent',
        'CmdCommitTime',
        'CmdTransTime',
        'CmdOverTime',
        'CmdReturn',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public static function pending(string $deviceId): ?DeviceCmd
    {
        return self::where('CmdTransTime', null)
            ->where('SN', $deviceId)
            ->get()
            ->first();
    }

    public static function setCmd(string $deviceId, string $cmd): DeviceCmd
    {
        return self::create([
            'SN' => $deviceId,
            'user_id' => 1,
            'CmdOrder' => self::where('SN', $deviceId)->max('CmdOrder') + 1,
            'CmdContent' => $cmd,
            'CmdCommitTime' => now(),
        ]);
    }
}
