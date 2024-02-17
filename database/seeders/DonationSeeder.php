<?php

namespace Database\Seeders;

use App\Models\Compaign;
use App\Models\Donation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Compaign::select(['id'])->get() as $compaign) {
            Donation::factory(fake()->numberBetween(15, 25))->create(['compaign_id' => $compaign->id]);
        }
    }
}
