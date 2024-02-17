<?php

namespace Database\Factories;

use App\Enums\DonationStatus;
use App\Models\Donor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donation>
 */
class DonationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $donor = Donor::inRandomOrder()->first();
        $amount = fake()->numberBetween(10, 99);
        $processing_fee = fake()->numberBetween(1, 5);
        $type = fake()->randomElement(['stripe', 'paypal']);

        return [
            'donor_id' => $donor->id,
            'amount' => $amount,
            'formatted_amount' => '$' . $amount,
            'currency' => 'usd',
            'type' => $type,
            'stripe_charge_id' => $type === 'stripe' ? Str::random(20) : null,
            'paypal_transaction_id' => $type === 'paypal' ? Str::random(20) : null,
            'status' => DonationStatus::PAID->value,
            'processing_fee' => $processing_fee,
            'formatted_processing_fee' => '$' . $processing_fee,
            'created_at' => now()->subDays(fake()->numberBetween(2, 45))
        ];
    }
}
