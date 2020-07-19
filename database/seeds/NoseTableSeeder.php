<?php

use App\Models\nose_master;
use Illuminate\Database\Seeder;

class NoseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add this lines
        nose_master::query()->truncate(); // truncate nose table each time of seeders run
        $nose_seeds = config('nose_seeds.noses');
        if (isset($nose_seeds) && !empty($nose_seeds)) {
            foreach ($nose_seeds as $nose_key => $nose_val) {
                nose_master::create($nose_val);
            }
        }
    }
}
