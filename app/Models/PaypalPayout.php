<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class PaypalPayout extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['compaign_id', 'payout_id', 'amount', 'currency', 'status'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function compaign(): BelongsTo
    {
        return $this->belongsTo(Compaign::class);
    }

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
}
