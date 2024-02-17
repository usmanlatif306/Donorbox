<?php

namespace App\Enums;

enum DonationStatus: string
{
    case PAID     = 'paid';
    case UNPAID   = 'unpaid';
}
