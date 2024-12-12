<?php

namespace App\Custom;

class CDataParser
{
    private string $data;

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    public function parseAttlog(): array
    {
        $lines = preg_split('/\\r\\n|\\r|,|\\n/', $this->data);
        $parsedData = [];

        foreach ($lines as $line) {
            if (trim($line) === '') {
                continue;
            }

            $fields = explode("\t", $line);
            $parsedData[] = [
                'employee_id' => $fields[0],
                'checktime' => $fields[1],
                'checktype' => (int) $fields[2],
                'verifycode' => $fields[3],
                'WorkCode' => $fields[4] ?? null,
                'Reserved' => $fields[5] ?? null,
                'Reserved2' => $fields[6] ?? null,
            ];
        }

        return $parsedData;
    }
}
