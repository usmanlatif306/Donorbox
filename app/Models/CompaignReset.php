<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompaignReset extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['compaign_id', 'last_stripe_total', 'last_stripe_total_with_tax', 'last_paypal_total', 'last_paypal_total_with_tax'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'last_stripe_total' => 'float',
        'last_stripe_total_with_tax' => 'float',
        'last_paypal_total' => 'float',
        'last_paypal_total_with_tax' => 'float',
    ];
}
