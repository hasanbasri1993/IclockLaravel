<?php

namespace App\Custom;

class OperLog
{
    private string $rawData;

    public function __construct(string $rawData)
    {
        $this->rawData = $rawData;
    }

    public function parser(): array
    {
        $items = explode("\n", $this->rawData);
        $data = [];

        foreach ($items as $item) {
            $breakIndex = strpos($item, ' ');
            $opType = substr($item, 0, $breakIndex);
            $content = substr($item, $breakIndex + 1);
            if ($opType === '') {
                continue;
            }

            $itemData = match ($opType) {
                'OPLOG' => $this->parseOplogData($content),
                'USER', 'FP' => $this->parseUserData($content),
            };

            $data[] = [
                'opType' => $opType,
                'data' => $itemData,
            ];
        }

        return $data;
    }

    public function parseOplogData($content): array
    {
        $keyValuePairs = explode("\t", $content);
        $entryData = [];

        ///OPLOGS<spasi>OpType<tab>OpWho<tab>OpTime<tab>Value1<tab>Value2<tab>Value3<tab>Reserved OpType: Operation Type. Daftar OpType:
        $entryData['OpType'] = $keyValuePairs[0];
        $entryData['OpWho'] = $keyValuePairs[1];
        $entryData['OpTime'] = $keyValuePairs[2];
        $entryData['Value1'] = $keyValuePairs[3];
        $entryData['Value2'] = $keyValuePairs[4];
        $entryData['Value3'] = $keyValuePairs[5];
        $entryData['Reserved'] = $keyValuePairs[6];

        return $entryData;
    }

    public function getDescriptions(int $OpType): string
    {
        $desc = [
            0 => 'Startup',
            1 => 'Shutdown',
            2 => 'Authentication fails',
            3 => 'Alarm',
            4 => 'Access menu',
            5 => 'Change settings',
            6 => 'Enroll fingerprint',
            7 => 'Enroll password',
            8 => 'Enroll HID card',
            9 => 'Delete user',
            10 => 'Delete fingerprint',
            11 => 'Delete password',
            12 => 'Delete RF card',
            13 => 'Clear data',
            14 => 'Create MF card',
            15 => 'Enroll MF card',
            16 => 'Register MF card',
            17 => 'Delete MF card registration',
            18 => 'Clear MF card content',
            19 => 'Move enrolled data into the card',
            20 => 'Copy data in the card to the machine',
            21 => 'Set time',
            22 => 'Delivery configuration',
            23 => 'Delete entry and exit records',
            24 => 'Clear administrator privilege',
        ];

        return $desc[$OpType];
    }

    public function parseUserData(string $content): array
    {
        $keyValuePairs = explode("\t", $content);
        $entryData = [];

        foreach ($keyValuePairs as $pair) {
            // Split key and value
            [$key, $value] = explode('=', $pair, 2);
            $entryData[$key] = $value;
        }

        return $entryData;
    }
}
