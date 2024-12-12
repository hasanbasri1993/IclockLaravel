<?php

namespace App\Http\Controllers;

use App\Custom\CDataParser;
use App\Custom\DeviceOptions;
use App\Custom\OperLog;
use App\Models\Attendance;
use App\Models\Device;
use App\Models\DeviceCmd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IclockController extends Controller
{
    public function __invoke(Request $request) {}

    // handshake
    public function handshake(Request $request)
    {
        $deviceOption = (new DeviceOptions($request));
        Log::info('HANDSHAKE: '.$request->input('SN'));

        $device = Device::find($request->input('SN'));
        if ($device) {
            $deviceOption->updateDevice();
        } else {
            $deviceOption->createDevice();
        }

        return $deviceOption->getOptions();
    }

    public function receiveRecords(Request $request)
    {
        Log::info('RECEIVE RECORDS: '.$request->getContent());
        $table = $request->input('table');
        $sn = $request->input('SN');
        $rawData = $request->getContent();
        $cdDataParser = new CDataParser($rawData);
        if ($table == 'OPERLOG') {
            $data = (new OperLog($rawData))->parser();
            Log::info('OPERLOG: '.$sn, $data);

            return "OK:1\nPOST from: $sn";
        } elseif ($table == 'ATTLOG') {
            $stamp = $request->input('Stamp');
            $attLogs = array_map(function ($log) use ($stamp, $sn) {
                $log['sn'] = $sn;
                $log['stamp'] = $stamp;

                return $log;
            }, $cdDataParser->parseAttlog());
            foreach ($attLogs as $attLog) {
                try {
                    Attendance::create($attLog);
                } catch (\Exception $e) {
                    Log::error('Error: '.$e->getMessage());
                }
            }

            return response('OK: '.count($attLogs));
        }

        return 'OK';
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
        $deviceCmd = DeviceCmd::where('SN', $sn)
            ->where('CmdOrder', $cmd_id)
            ->where('CmdContent', $cmd_data)
            ->first();
        if ($deviceCmd) {
            $deviceCmd->CmdOverTime = now();
            $deviceCmd->CmdReturn = $cmdError;
            $deviceCmd->save();

            if ($cmd_data == 'CHECK') {
                $device = Device::find($sn);
                $device->LogStamp = 99999;
                $device->OpLogStamp = 99999;
                $device->PhotoStamp = 99999;
                $device->save();
            }
            Log::error("DeviceCmd not found for $deviceCmd device_id: $sn, cmd_id: $cmd_id, cmd_data: $cmd_data");
        }

        return 'OK';
    }

    public function getrequest(Request $request)
    {
        $deviceOption = (new DeviceOptions($request));
        $sn = $request->input('SN');
        $info = $request->input('INFO');
        if ($info && $sn) {
            $deviceOption->updateDeviceInfo();
        }

        Device::find($sn)->update(['LastActivity' => now(), 'State' => 1]);
        $deviceCmd = DeviceCmd::pending($sn);
        if ($deviceCmd) {
            Log::log('info', 'GET REQUEST: '.$sn.$deviceCmd->CmdContent);
            $deviceCmd->update(['CmdTransTime' => now()]);

            return "C:$deviceCmd->CmdOrder:$deviceCmd->CmdContent";
        }

        return 'OK';
    }
}
