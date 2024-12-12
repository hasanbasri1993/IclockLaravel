<?php

namespace App\Custom;

use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DeviceOptions
{
    private string $SN;

    private int $Stamp;

    private int $ErrorDelay;

    private int $Delay;

    private string $TransTimes;

    private int $TransInterval;

    private string $TransFlag;

    private int $TimeZone;

    private int $Realtime;

    private string $Encrypt;

    private int $OperLogStamp;

    private int $AttPhotoStamp;

    private int $AttLogStamp;

    private string $pushVersion;

    private string $deviceInfo;

    public function __construct(Request $request)
    {
        $this->SN = $request->input('SN');
        $this->pushVersion = $request->input('pushver') ?? '';
        $this->deviceInfo = $request->input('INFO') ?? '';
        $device = Device::find($this->SN);

        $this->Stamp = $device ? $device->LogStamp : 9999;
        $this->OperLogStamp = $device ? $device->OpLogStamp : 9999;
        $this->AttLogStamp = $device ? $device->LogStamp : 9999;
        $this->AttPhotoStamp = $device ? $device->PhotoStamp : 9999;
        $this->ErrorDelay = 30;
        $this->Delay = 30;
        $this->TransTimes = $device ? $device->TransTimes : '00:00;14:05';
        $this->TransInterval = $device ? $device->TransInterval : 1;
        $this->TransFlag = $device ? $device->UpdateDB : '1111111100';
        $this->TimeZone = $device ?
            $device->TZAdj :
            Carbon::now(config('app.timezone'))->offsetHours;
        $this->Realtime = 1;
        $this->Encrypt = 'NONE';
    }

    public function getOptions(): string
    {
        return "GET OPTION FROM: {$this->SN}\r\n".
            'ATTLOGStamp='.$this->AttLogStamp."\r\n".
            'OPERLOGStamp='.$this->OperLogStamp."\r\n".
            'ATTPHOTOStamp='.$this->AttPhotoStamp."\r\n".
            "ErrorDelay={$this->ErrorDelay}\r\n".
            "Delay={$this->Delay}\r\n".
            "TransTimes={$this->TransTimes}\r\n".
            "TransInterval={$this->TransInterval}\r\n".
            "TransFlag={$this->TransFlag}\r\n".
            'TimeZone='.$this->TimeZone."\r\n".
            "Realtime={$this->Realtime}\r\n".
            'Encrypt='.$this->Encrypt."\r\n".
            "ServerVer=2.2.14\r\n".
            'TableNameStamp';
    }

    public function createDevice(): void
    {
        $data = [
            'SN' => $this->SN,
            'State' => 1,
            'LastActivity' => now(),
            'LogStamp' => $this->AttLogStamp,
            'OpLogStamp' => $this->OperLogStamp,
            'PhotoStamp' => $this->AttPhotoStamp,
            'TransTimes' => $this->TransTimes,
            'TransInterval' => $this->TransInterval,
            'TZAdj' => $this->TimeZone,
            'PushVersion' => $this->pushVersion,
        ];
        Device::create($data);
    }

    public function updateDevice(): void
    {
        $device = Device::find($this->SN);
        $data = [
            'SN' => $this->SN,
            'State' => 1,
            'PushVersion' => $this->pushVersion,
            'LastActivity' => now(),
        ];
        $device->update($data);
    }

    public function updateDeviceInfo(): void
    {
        $device = Device::find($this->SN);
        //INFO: Ver 8.0.4.2-20180713,285,522,1495,192.16.0.111,10,-1,0,0,101

        //URL ini terdiri dari 2 parameter, yaitu SN dan INFO. SN merupakan serial number mesin,
        //sedangkan parameter INFO terdiri dari beberapa nilai dipisahkan koma yaitu:
        //
        //Nilai ke	Deskripsi
        //0	Firmware version number
        //1	Number of enrolled users
        //2	Number of enrolled fingerprints
        //3	Number of attendance records
        //4	IP address of Equioment
        //5	Version of fingerprint algorithm
        //6	Version of face algorithm
        //7	Number of faces required for face enrollment,
        //8	Number of enrolled faces
        //9	Angka yang menunjukkan fungsi yang didukung mesin
        $info = explode(',', $this->deviceInfo);
        $device->update([
            'SN' => $this->SN,
            'State' => 1,
            'FWVersion' => $info[0],
            'UserCount' => $info[1],
            'FPCount' => $info[2],
            'TransactionCount' => $info[3],
            'IPAddress' => $info[4],
            'AlgVer' => $info[5],
            'FPVersion' => $info[6],
            'LastActivity' => now(),
        ]);
    }
}
