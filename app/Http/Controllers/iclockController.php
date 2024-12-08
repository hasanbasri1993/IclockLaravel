<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceCmd;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class iclockController extends Controller
{
    public function __invoke(Request $request) {}

    // handshake
    public function handshake(Request $request)
    {
        $data = [
            'url' => json_encode($request->all()),
            'data' => $request->getContent(),
            'sn' => $request->input('SN'),
            'option' => $request->input('option'),
        ];
        DB::table('device_log')->insert($data);

        // update status device
        DB::table('devices')->updateOrInsert(
            ['no_sn' => $request->input('SN')],
            ['online' => now()]
        );

        return "GET OPTION FROM: {$request->input('SN')}\r\n".
            "Stamp=9999\r\n".
            'OpStamp='.time()."\r\n".
            "ErrorDelay=60\r\n".
            "Delay=30\r\n".
            "ResLogDay=18250\r\n".
            "ResLogDelCount=10000\r\n".
            "ResLogCount=50000\r\n".
            "TransTimes=00:00;14:05\r\n".
            "TransInterval=1\r\n".
            "TransFlag=1111000000\r\n".
            'TimeZone='.Carbon::now(config('app.timezone'))->offsetHours."\r\n".
            "Realtime=1\r\n".
            'Encrypt=0';
    }

    public function receiveRecords(Request $request)
    {
        Log::info('RECEIVE RECORDS: '.$request->getContent());
        $content['url'] = json_encode($request->all());
        $content['data'] = $request->getContent();
        DB::table('finger_log')->insert($content);
        try {
            $arr = preg_split('/\\r\\n|\\r|,|\\n/', $request->getContent());
            $tot = 0;
            if ($request->input('table') == 'OPERLOG') {
                foreach ($arr as $rey) {
                    if (isset($rey)) {
                        $tot++;
                    }
                }
                Log::log('info', 'OPERLOG: '.$tot);

                return 'OK: '.$tot;
            }
            foreach ($arr as $rey) {
                if (empty($rey)) {
                    continue;
                }
                $data = explode("\t", $rey);
                $q['sn'] = $request->input('SN');
                $q['table'] = $request->input('table');
                $q['stamp'] = $request->input('Stamp');
                $q['employee_id'] = $data[0];
                $q['timestamp'] = $data[1];
                $q['status1'] = $this->validateAndFormatInteger($data[2] ?? null);
                $q['status2'] = $this->validateAndFormatInteger($data[3] ?? null);
                $q['status3'] = $this->validateAndFormatInteger($data[4] ?? null);
                $q['status4'] = $this->validateAndFormatInteger($data[5] ?? null);
                $q['status5'] = $this->validateAndFormatInteger($data[6] ?? null);
                $q['created_at'] = now();
                $q['updated_at'] = now();
                DB::table('attendances')->insert($q);
                $tot++;
            }
            Log::log('info', $request->input('table').': '.$tot);

            return response('OK: '.$tot);
        } catch (Throwable $e) {
            $data['error'] = $e;
            DB::table('error_log')->insert($data);
            report($e);
            Log::log('error', $request->input('table').': '.$e->getMessage());

            return 'ERROR: '."\n";
        }
    }

    public function devicecmd(Request $request)
    {
        $sn = $request->input('SN');
        $cmd = $request->getContent();
        $cmd = explode('&', $cmd);
        $cmd_id = trim(explode('=', $cmd[0])[1]);
        $cmdError = trim(explode('=', $cmd[1])[1]);
        $cmd_data = trim(explode('=', $cmd[2])[1]);
        if ($cmdError != '0') {
            Log::error("ada error: pada sn $sn", $cmd);
        }
        $device = Device::where('no_sn', $sn)->first();
        Log::info('DEVICE CMD: '.$sn.$device->id);
        $deviceCmd = DeviceCmd::where('device_id', $device->id)
            ->where('cmd_id', $cmd_id)
            ->where('cmd_data', $cmd_data)
            ->first();
        if ($deviceCmd) {
            $deviceCmd->cmd_status = 'success';
            $deviceCmd->save();
        } else {
            Log::error("DeviceCmd not found for $deviceCmd device_id: $device->id, cmd_id: $cmd_id, cmd_data: $cmd_data");
        }

        return 'OK';
    }

    public function test(Request $request)
    {
        $log['data'] = $request->getContent();
        DB::table('finger_log')->insert($log);
    }

    public function getrequest(Request $request)
    {
        DB::table('devices')->updateOrInsert(
            ['no_sn' => $request->input('SN')],
            ['online' => now()]
        );

        $deviceCmd = DeviceCmd::pending($request->input('SN'));
        if ($deviceCmd) {
            Log::log('info', 'GET REQUEST: '.$request->input('SN').$deviceCmd->cmd_data);
            $deviceCmd->update(['cmd_status' => 'sent']);

            return "C:$deviceCmd->cmd_id:$deviceCmd->cmd_data";
        }

        return 'OK';
    }

    private function validateAndFormatInteger($value)
    {
        return isset($value) && $value !== '' ? (int) $value : null;
    }
}
