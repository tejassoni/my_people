<?php

use App\Models\country_master;
use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add this lines
        country_master::query()->truncate(); // truncate country table each time of seeders run
        $country_seeds = config('country_seeds.countries');
        if (isset($country_seeds) && !empty($country_seeds)) {
            foreach ($country_seeds as $country_key => $country_val) {
                country_master::create($country_val);
            }
        }
    }
}
