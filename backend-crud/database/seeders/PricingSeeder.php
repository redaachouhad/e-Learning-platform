<?php

namespace Database\Seeders;

use App\Models\Pricing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pricingTypes = [
            "paid",
            "free",
            "on sale"
        ];

        foreach ($pricingTypes as $pricingType) {
            Pricing::create(["type" => $pricingType]);
        }
    }
}
