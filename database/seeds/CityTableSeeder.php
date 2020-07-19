<?php

use App\Models\city_master;
use Illuminate\Database\Seeder;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add this lines
        city_master::query()->truncate(); // truncate city table each time of seeders run
        $city_seeds = config('city_seeds.cities');
        if (isset($city_seeds) && !empty($city_seeds)) {
            foreach ($city_seeds as $city_key => $city_val) {
                city_master::create($city_val);
            }
        }
    }
}
