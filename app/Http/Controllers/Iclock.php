<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Iclock extends Controller
{
    public function cdata(Request $request)
    {
        // Get the SN, options, language, and pushver parameters from the URL
        // Get the request data
        $SN = $request->get('SN');
        $table = $request->get('table');
        $rawData = $request->getContent();

        // Split the raw data into lines
        $rawData = explode("\n", $rawData);

        switch ($table) {
            case 'ATTLOG':
                $this->attlog($SN, $rawData);
                break;

            default:
                echo 'OK';
                break;
        }
    }


    function GetCdata(Request $request)
    {
        // Get the SN, options, language, and pushver parameters from the URL
        $SN = $request->get('SN');
        $pushver = $request->get('pushver');

        // Perform any parsing or processing here if needed
        Log::log('info', 'SN: ' . $SN);
        Log::log('info', 'pushver: ' . $pushver);

        if (isset($pushver)) {
            return response("GET OPTION FROM: $SN
ATTLOGStamp=None
OPERLOGStamp=9999
ATTPHOTOStamp=None
ErrorDelay=30
Delay=10
TransTimes=00:00;14: 05
Transinterval=1
TransFlag=AttLog
TimeZone=7
Realtime=1
Encrypt=None");
        }
        return "";
    }

    public function GetRequest()
    {
        return response('OK');
    }

    public function attlog(string $SN, array $rawData)
    {
        // 222310045    2023-11-16 17:31:37	1	1	0	0	0	0	0	0
        // 222310045	2023-11-16 17:31:37	1	1	0	0	0	0	0	0
        Log::log('info', 'SN: ' . $SN);
        Log::log('info', 'RawData: ' . json_encode($rawData));

        // Loop through each line and parse the data
        foreach ($rawData as $key => $value) {
            //Log::log('info', "Data[$key]: $value");
            $data = preg_split('/\s+/', $value);

            if ($value != '') {
                $user_id = $data[0];//contains the first value (e.g., 114)
                $date = $data[1] . ' ' . $data[2];//contains the timestamp (e.g., 2023-09-23 01:28:15)
                $status = $data[3]; //, $data[3], $data[4], $data[5], etc., contain other
                Log::info('ID User: ' . $user_id . ' Tanggal: ' . $date . ' Status:' . $status);
//                if ($attlogModel->check($user_id, $date, $status) == 0 && $data[0] != '') {
//                    $attlogEntity = new AttlogEntity(
//                        0,
//                        $user_id,
//                        $SN,
//                        $status,
//                        $date,
//                        0
//                    );
//
//                    log_message('info', 'HumanData: ' . json_encode($data));
//                    $getLogId = $attlogModel->insert($attlogEntity->getDataArray());
//                    $attlogEntity->setId($getLogId);
//                    (new UploadAttlog())->post($attlogEntity);
//                }
            }
        }
        echo "OK: " . count($rawData);
    }
}
