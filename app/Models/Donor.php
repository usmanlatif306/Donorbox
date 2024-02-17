<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Donor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'first_name', 'last_name', 'email', 'phone', 'address', 'city', 'state', 'zip_code', 'country', 'comment', 'total_donation', 'last_donation_at', 'donations_count', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'last_donation_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * Get the user's name.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['first_name'] . ' ' . $attributes['last_name'],
        );
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }
}
