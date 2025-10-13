<?php

namespace App\Enums;

enum OutcomeStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Cancelled = 'canceled';
}
