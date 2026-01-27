<?php

namespace App\Enums;

enum PaymentStatus: int {
    case PAID = 0 ;
    case UNPAID = 1 ;
}