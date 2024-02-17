<?php

namespace App\Enums;

enum DonationType: string
{
    case STRIPE   = 'stripe';
    case PAYPAL   = 'paypal';
}
