<?php

use App\Enums\PropertyStatus;
use App\Models\Amenity;

if (!function_exists('name_alphabetic')) {
    function name_alphabetic($name)
    {
        return array_reduce(
            explode(' ', $name),
            function ($initials, $word) {
                return sprintf('%s%s', $initials, substr($word, 0, 1));
            },
            ''
        );
    }
}

if (!function_exists('random_colour')) {
    function random_colour()
    {
        $colours = ['primary', 'success', 'secondary', 'info', 'danger', 'dark'];

        $random_keys = array_rand($colours);

        return $colours[$random_keys];
    }
}

if (!function_exists('badge_colour')) {
    function badge_colour($status)
    {
        if ($status === 'verified') {
            return 'badge-success';
        } elseif ($status === 'rejected') {
            return 'badge-danger';
        } else {
            return 'badge-primary';
        }
    }
}

if (!function_exists('formatted_number')) {
    function formatted_number($number, $precise = 2)
    {
        $number = number_format($number, $precise);
        return str_replace('.00', '', $number);
    }
}
