<?php

namespace App\Enums;

enum AddressType: int{
    case USER_SAVED = 0;
    case SHIPPING_ADDRESS = 1;
}