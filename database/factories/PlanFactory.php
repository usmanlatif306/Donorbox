<?php

namespace Database\Factories;

use App\Models\Donor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
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
        $type = fake()->randomElement(['weekly', 'monthly', 'yearly']);
        $next_donation_days = $type === 'weekly' ? 7 : ($type === 'monthly' ? 7 : 365);
        $last_donation = now()->subDays(fake()->numberBetween(10, 90));

        return [
            'donor_id' => $donor->id,
            'amount' => $amount,
            'formatted_amount' => '$' . $amount,
            'type' => $type,
            'payment_method' => fake()->randomElement(['stripe', 'paypal']),
            'status' => 'active',
            'last_donation_date' => $last_donation,
            'next_donation_date' => $last_donation->addDays($next_donation_days)->format('Y-m-d'),
            'created_at' => $last_donation
        ];
    }
}
