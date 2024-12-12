<?php

namespace App\Custom;

class FP
{
    private string $PIN;

    private string $FID;

    private string $Size;

    private string $Valid;

    private string $TMP;

    private string $SN;

    public function __construct(array $data)
    {
        $this->PIN = $data['PIN'];
        $this->FID = $data['FID'];
        $this->Size = $data['Size'];
        $this->Valid = $data['Valid'];
        $this->TMP = $data['TMP'];
        $this->SN = $data['SN'];
    }

    public function getPIN(): string
    {
        return $this->PIN;
    }

    public function setPIN(string $PIN): void
    {
        $this->PIN = $PIN;
    }

    public function getFID(): string
    {
        return $this->FID;
    }

    public function setFID(string $FID): void
    {
        $this->FID = $FID;
    }

    public function getSize(): string
    {
        return $this->Size;
    }

    public function setSize(string $Size): void
    {
        $this->Size = $Size;
    }

    public function getValid(): string
    {
        return $this->Valid;
    }

    public function setValid(string $Valid): void
    {
        $this->Valid = $Valid;
    }

    public function getTMP(): string
    {
        return $this->TMP;
    }

    public function setTMP(string $TMP): void
    {
        $this->TMP = $TMP;
    }

    public function getSN(): string
    {
        return $this->SN;
    }

    public function setSN(string $SN): void
    {
        $this->SN = $SN;
    }
}
