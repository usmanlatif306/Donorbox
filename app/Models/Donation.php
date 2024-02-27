<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Donation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['compaign_id', 'donor_id', 'amount', 'formatted_amount', 'currency', 'type', 'stripe_charge_id', 'paypal_transaction_id', 'status', 'recurring', 'processing_fee', 'formatted_processing_fee', 'donation_date', 'id', 'created_at', 'updated_at', 'culacted'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'donation_date' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * Scope a query to only include records between duration.
     */
    public function scopeDuration(Builder $query, string $type): void
    {
        if ($type === "week") {
            $query->week();
        } elseif ($type === "month") {
            $query->month();
        } elseif ($type === "quarter") {
            $query->quarter();
        } elseif ($type === "6_months") {
            $query->halfYear();
        } elseif ($type === "year") {
            $query->year();
        }
    }

    public function compaign(): BelongsTo
    {
        return $this->belongsTo(Compaign::class);
    }

    public function donor(): BelongsTo
    {
        return $this->belongsTo(Donor::class);
    }
}
