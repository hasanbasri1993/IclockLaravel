<?php

namespace Tests\Unit;

use App\Models\Device;
use App\Models\DeviceCmd;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }

    public function test_sent_cmd()
    {
        $device = Device::first();

        $device->OpLogStamp = 0;
        $device->LogStamp = 0;
        $device->save();

        $deviceCmd = new DeviceCmd;
        $deviceCmd->setCmd($device->SN, 'CHECK');
        $this->assertTrue(true);

    }

    public function test_get_pending_cmd()
    {
        $device = Device::find(1);
        $deviceCmd = new DeviceCmd;
        $this->assertEquals('CHECK', $deviceCmd->pending($device->id)->cmd_data);
        var_dump($deviceCmd->pending($device->id)->cmd_data);
    }

    public function test_update_success()
    {
        $sn = 'BWXP185061835';
        $cmd = 'ID=1&Return=0&CMD=CHECK';
        $cmd = explode('&', $cmd);
        $cmd_id = explode('=', $cmd[0])[1];
        $cmdError = explode('=', $cmd[1])[1];
        $cmd_data = explode('=', $cmd[2])[1];
        var_dump($cmd, $cmd_id, $cmdError, $cmd_data);
        if ($cmdError != '0') {
            var_dump('ada error');
        }
        DB::connection()->enableQueryLog();
        $device = Device::where('no_sn', $sn)->first();
        $deviceCmd = DeviceCmd::where('device_id', $device->id)->where('cmd_id', $cmd_id)->where('cmd_data', $cmd_data)->first();
        var_dump($deviceCmd->id);
        $deviceCmd->cmd_status = 'success';
        $deviceCmd->save();
        var_dump(DB::getQueryLog());
    }
}
