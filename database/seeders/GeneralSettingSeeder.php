<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GeneralSetting;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GeneralSetting::create([
            'upto_50' => 5,
            'upto_50_150' => 6,
            'upto_150_300' => 7,
            'above_300' => 8,
            'tariff_dg' => 10,
            'service_tax_dg' => 0,
            'electricity_upto' => 100,
            'electicity_value' => 6.5,
            'electicity_above_value' => 7,
            'late_percentage' => 1.25,
            'maintain_cost' => 1.25,
        ]);
    }
}
