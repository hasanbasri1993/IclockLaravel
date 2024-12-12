<?php

namespace App\Custom;

class UserInfo
{
    private string $PIN;

    private string $Name;

    private string $Pri;

    private string $Passwd;

    private string $Card;

    private string $Grp;

    private string $TZ;

    private string $Verify;

    private string $ViceCard;

    private string $SN;

    public function __construct(array $data)
    {
        $this->PIN = $data['PIN'];
        $this->Name = $data['Name'];
        $this->Pri = $data['Pri'];
        $this->Passwd = $data['Passwd'];
        $this->Card = $data['Card'];
        $this->Grp = $data['Grp'];
        $this->TZ = $data['TZ'];
        $this->Verify = $data['Verify'];
        $this->ViceCard = $data['ViceCard'];
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

    public function getName(): string
    {
        return $this->Name;
    }

    public function setName(string $Name): void
    {
        $this->Name = $Name;
    }

    public function getPri(): string
    {
        return $this->Pri;
    }

    public function setPri(string $Pri): void
    {
        $this->Pri = $Pri;
    }

    public function getPasswd(): string
    {
        return $this->Passwd;
    }

    public function setPasswd(string $Passwd): void
    {
        $this->Passwd = $Passwd;
    }

    public function getCard(): string
    {
        return $this->Card;
    }

    public function setCard(string $Card): void
    {
        $this->Card = $Card;
    }

    public function getGrp(): string
    {
        return $this->Grp;
    }

    public function setGrp(string $Grp): void
    {
        $this->Grp = $Grp;
    }

    public function getTZ(): string
    {
        return $this->TZ;
    }

    public function setTZ(string $TZ): void
    {
        $this->TZ = $TZ;
    }

    public function getVerify(): string
    {
        return $this->Verify;
    }

    public function setVerify(string $Verify): void
    {
        $this->Verify = $Verify;
    }

    public function getViceCard(): string
    {
        return $this->ViceCard;
    }

    public function setViceCard(string $ViceCard): void
    {
        $this->ViceCard = $ViceCard;
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
