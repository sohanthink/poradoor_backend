<?php

namespace App\Enums;

enum ShippingMethod: int {
    case STANDARD = 0;
    case EXPEDITED = 2;
    case OVERNIGHT = 3;
    case SAMEDAY = 4;
}