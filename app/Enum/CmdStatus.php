<?php

namespace App\Enum;

enum CmdStatus: string
{
    case PENDING = 'pending';
    case SENT = 'sent';
    case SUCCESS = 'success';
    case FAILED = 'failed';

}
