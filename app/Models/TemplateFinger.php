<?php

namespace App\Models;

use App\Custom\FP;
use Illuminate\Database\Eloquent\Model;

class TemplateFinger extends Model
{
    protected $guarded = [];

    //      "PIN": "1",
    //      "FID": "6",
    //      "Size": "1344",
    //      "Valid": "1",
    //      "TMP": "Sq1TUzIxAAAD7****",
    //      "SN": "A6G6231960172"
    public static function saveFinger(FP $fp): void
    {
        $userInfo = UserInfo::getUser($fp->getSN(), $fp->getPIN());
        if ($userInfo) {

            $finger = self::where('userid', $userInfo->userid)
                ->where('FingerID', $fp->getFID())
                ->first();

            if ($finger) {
                $finger->update([
                    'Template' => $fp->getTMP(),
                    'Valid' => $fp->getValid(),
                    'DelTag' => 0,
                    'UTime' => now(),
                ]);

            } else {
                self::create([
                    'Template' => $fp->getTMP(),
                    'Valid' => $fp->getValid(),
                    'DelTag' => 0,
                    'UTime' => now(),
                    'FingerID' => $fp->getFID(),
                    'userid' => $userInfo->userid,
                ]);

            }
        }
    }
}
