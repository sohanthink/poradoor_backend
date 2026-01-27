<?php

namespace App\Enums;

enum ShippingMethod: int {
    case STANDARD = 0;
    case EXPEDITED = 1;
    case OVERNIGHT = 2;
    case SAMEDAY = 3;
}