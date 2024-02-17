<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Plan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['compaign_id', 'donor_id', 'amount', 'formatted_amount', 'type', 'payment_method', 'status', 'last_donation_date', 'next_donation_date', 'id', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'last_donation_date' => 'datetime',
        'next_donation_date' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function compaign(): BelongsTo
    {
        return $this->belongsTo(Compaign::class);
    }

    public function donor(): BelongsTo
    {
        return $this->belongsTo(Donor::class);
    }
}
