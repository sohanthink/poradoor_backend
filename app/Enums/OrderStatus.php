<?php

namespace App\Enums;

enum OrderStatus: int{
    case PENDING = 0;
    case ACCEPT = 1;
    case PROCESSING = 2;
    case SHIPPING = 3;
    case DELIVERED = 4;
    case CANCEL = 5;
}