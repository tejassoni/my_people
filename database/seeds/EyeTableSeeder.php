<?php

use App\Models\eye_master;
use Illuminate\Database\Seeder;

class EyeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add this lines
        eye_master::query()->truncate(); // truncate eye table each time of seeders run
        $eye_seeds = config('eye_seeds.eyes');
        if (isset($eye_seeds) && !empty($eye_seeds)) {
            foreach ($eye_seeds as $eye_key => $ear_val) {
                eye_master::create($ear_val);
            }
        }
    }
}
