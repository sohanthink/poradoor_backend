<?php

namespace App\Enums;

enum CouponType: int{
    case PERCENTAGE = 0;
    case FIXED = 1;
}