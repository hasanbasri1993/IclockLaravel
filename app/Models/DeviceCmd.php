<?php

namespace App\Models;

use App\Enum\CmdStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceCmd extends Model
{
    protected $table = 'device_cmds';

    protected $fillable = ['device_id', 'cmd_id', 'cmd_data', 'cmd_status'];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public static function pending(string $deviceId): ?DeviceCmd
    {
        $idDevice = Device::where('no_sn', $deviceId)->get()->first()->id;
        return self::where('cmd_status', 'pending')->where('device_id', $idDevice)->get()->first();
    }

    public function setCmd(string $deviceId, string $cmd): DeviceCmd
    {
        return $this->create([
            'device_id' => $deviceId,
            'cmd_id' => $this->where('device_id', $deviceId)->max('cmd_id') + 1,
            'cmd_data' => $cmd,
            'cmd_status' => CmdStatus::PENDING,
        ]);
    }
}
