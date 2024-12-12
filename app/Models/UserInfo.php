<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $guarded = [];

    //      "PIN": "123",
    //      "Name": "Risky Amanda Firdaus",
    //      "Pri": "0",
    //      "Passwd": "",
    //      "Card": "",
    //      "Grp": "1",
    //      "TZ": "0000000000000000",
    //      "Verify": "-1",
    //      "ViceCard": "",
    //      "SN": "A6G6231960172"

    public static function saveUser(\App\Custom\UserInfo $userInfo): void
    {
        $userInfoDb = self::where('SN', $userInfo->getSN())
            ->where('badgenumber', $userInfo->getPIN())
            ->first();
        if ($userInfoDb) {
            $userInfoDb->update([
                'name' => $userInfo->getName(),
                'Privilege' => $userInfo->getPri(),
                'Password' => $userInfo->getPasswd(),
                'Card' => $userInfo->getCard(),
                'AccGroup' => $userInfo->getGrp(),
                'defaultdeptid' => $userInfo->getGrp(),
                'TimeZones' => $userInfo->getTZ(),
                //'Verify' => $userInfo['Verify'],
                'SN' => $userInfo->getSN(),
            ]);
        } else {
            self::create([
                'name' => $userInfo->getName(),
                'Privilege' => $userInfo->getPri(),
                'Password' => $userInfo->getPasswd(),
                'Card' => $userInfo->getCard(),
                'AccGroup' => $userInfo->getGrp(),
                'defaultdeptid' => $userInfo->getGrp(),
                'TimeZones' => $userInfo->getTZ(),
                'DelTag' => 0,
                //'Verify' => $userInfo['Verify'],
                'SN' => $userInfo->getSN(),
                'badgenumber' => $userInfo->getPIN(),
            ]);
        }
    }

    public static function getUser(string $SN, string $badgenumber): ?UserInfo
    {
        return self::where('SN', $SN)
            ->where('badgenumber', $badgenumber)
            ->first();
    }
}
