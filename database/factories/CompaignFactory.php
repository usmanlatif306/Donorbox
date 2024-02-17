<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Compaign>
 */
class CompaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->sentence();
        $goal_amt = fake()->numberBetween(9999, 999999);
        $total_raised = fake()->numberBetween(1000, 9999);

        return [
            'name' => $name,
            'currency' => 'usd',
            'goal_amt' => $goal_amt,
            'formatted_goal_amount' => '$' . $goal_amt,
            'total_raised' => $total_raised,
            'formatted_total_raised' => '$' . $total_raised,
            'donations_count' => fake()->numberBetween(10, 99)
        ];
    }
}
