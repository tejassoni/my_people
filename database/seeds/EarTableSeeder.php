<?php

use App\Models\ear_master;
use Illuminate\Database\Seeder;

class EarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add this lines
        ear_master::query()->truncate(); // truncate ear table each time of seeders run
        $ear_seeds = config('ear_seeds.ears');
        if (isset($ear_seeds) && !empty($ear_seeds)) {
            foreach ($ear_seeds as $ear_key => $ear_val) {
                ear_master::create($ear_val);
            }
        }
    }
}
