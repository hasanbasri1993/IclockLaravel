<?php

namespace App\Http\Controllers;

use App\Custom\CDataParser;
use App\Custom\DeviceOptions;
use App\Custom\FP;
use App\Custom\OperLog;
use App\Custom\UserInfo as CustomUserInfo;
use App\Models\Attendance;
use App\Models\Device;
use App\Models\DeviceCmd;
use App\Models\TemplateFinger;
use App\Models\UserInfo;
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

            $attLogs = array_map(function ($log) use ($sn) {
                $log['data']['SN'] = $sn;

                return $log;
            }, $data);
            Log::info('OPERLOG: '.$sn, $attLogs);
            foreach ($attLogs as $attLog) {
                try {
                    switch ($attLog['opType']) {
                        case 'USER':
                            $userInfo = new CustomUserInfo($attLog['data']);
                            UserInfo::saveUser($userInfo);
                            break;
                        case 'FP':
                            $fp = new FP($attLog['data']);
                            TemplateFinger::saveFinger($fp);
                            break;
                        case 'OPLOG':
                            // TODO: save oplog
                            break;
                        default:
                            //Log::error('Unknown opType: '.$attLog['opType']);
                            break;
                    }
                } catch (\Exception $e) {
                    Log::error('Error: '.$e->getMessage());
                }
            }

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

        $parsedData = [];
        foreach (explode("\n", $cmd) as $line) {
            if (str_contains($line, '=')) {
                [$key, $value] = explode('=', $line, 2);
                if (trim($key) == 'ID') {
                    $parsedData[trim($key)] = trim('ID='.$value);
                } else {
                    $parsedData[trim($key)] = trim($value);
                }
            }
        }

        $cmd = explode('&', $parsedData['ID']);
        $cmd_id = trim(explode('=', $cmd[0])[1]);
        $cmdError = trim(explode('=', $cmd[1])[1]);
        $cmd_data = trim(explode('=', $cmd[2])[1]);

        Log::info("DEVICE CMD:  $sn:$cmd_id:$cmd_data", $cmd);
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
                $device->LogStamp = 9999;
                $device->OpLogStamp = 9999;
                $device->PhotoStamp = 9999;
                $device->save();
            } elseif ($cmd_data == 'INFO') {
                // Map parsed data to device table fields
                $deviceData = [
                    'SN' => $parsedData['~SerialNumber'] ?? null,
                    'DeviceName' => $parsedData['~DeviceName'] ?? null,
                    'TransactionCount' => $parsedData['TransactionCount'] ?? null,
                    'UserCount' => $parsedData['UserCount'] ?? null,
                    'MainTime' => $parsedData['MainTime'] ?? null,
                    'MaxFingerCount' => $parsedData['~MaxFingerCount'] ?? null,
                    'MaxAttLogCount' => $parsedData['~MaxAttLogCount'] ?? null,
                    'FPCount' => $parsedData['FPCount'] ?? null,
                    'FWVersion' => $parsedData['FWVersion'] ?? null,
                    'PushVersion' => $parsedData['PushVersion'] ?? null,
                    'AlgVer' => $parsedData['~AlgVer'] ?? null,
                    'FlashSize' => $parsedData['FlashSize'] ?? null,
                    'FreeFlashSize' => $parsedData['FreeFlashSize'] ?? null,
                    'Language' => $parsedData['Language'] ?? null,
                    'VOLUME' => $parsedData['VOLUME'] ?? null,
                    'DtFmt' => $parsedData['DtFmt'] ?? null,
                    'IPAddress' => $parsedData['IPAddress'] ?? null,
                    'IsTFT' => $parsedData['IsTFT'] ?? null,
                    'Platform' => $parsedData['~Platform'] ?? null,
                    'Brightness' => $parsedData['Brightness'] ?? null,
                    'BackupDev' => $parsedData['BackupDev'] ?? null,
                    'OEMVendor' => $parsedData['~OEMVendor'] ?? null,
                    'FPVersion' => $parsedData['FPVersion'] ?? null,
                ];

                Log::info('INFO: '.$sn, $deviceData);

                // Update or create the device record
                \DB::table('devices')->updateOrInsert(
                    ['SN' => $deviceData['SN']], // Unique key for identifying the device
                    $deviceData
                );
            }
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
