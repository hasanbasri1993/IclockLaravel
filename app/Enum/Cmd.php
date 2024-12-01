<?php

namespace App\Enum;

enum Cmd: string
{
    case CHECK = 'CHECK';
    case LOG = 'LOG';
    case REBOOT = 'REBOOT';
    case AC_UNLOCK = 'AC_UNLOCK';
    case AC_UNALARM = 'AC_UNALARM';
    case SHELL = 'SHELL';
    case DATA = 'DATA';

}
