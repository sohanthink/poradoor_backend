<?php

namespace App\Enums;

enum PaymentMethod: int{
    case CASH_ON_DELIVARY = 0;
    case ONLINE_PAY = 1;
}