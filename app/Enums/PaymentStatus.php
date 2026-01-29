<?php

namespace App\Enums;

enum PaymentStatus: int {
    case UNPAID = 0 ;
    case PAID = 1 ;
}