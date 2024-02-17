<?php

namespace Database\Seeders;

use App\Models\Compaign;
use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Compaign::select(['id'])->get() as $compaign) {
            Plan::factory(fake()->numberBetween(2, 9))->create(['compaign_id' => $compaign->id]);
        }
    }
}
