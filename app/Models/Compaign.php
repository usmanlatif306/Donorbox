<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Compaign extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'currency', 'goal_amt', 'formatted_goal_amount', 'total_raised', 'formatted_total_raised', 'donations_count', 'created_at', 'updated_at', 'show'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
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


    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function stripe_payouts(): HasMany
    {
        return $this->hasMany(StripePayout::class);
    }

    public function resets(): HasMany
    {
        return $this->hasMany(CompaignReset::class);
    }

    public function reset(): HasOne
    {
        return $this->hasOne(CompaignReset::class)->latestOfMany();
    }
}
