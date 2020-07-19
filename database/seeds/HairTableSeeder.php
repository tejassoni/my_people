<?php

use App\Models\hair_master;
use Illuminate\Database\Seeder;

class HairTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add this lines
        hair_master::query()->truncate(); // truncate hair table each time of seeders run
        $hair_seeds = config('hair_seeds.hairs');
        if (isset($hair_seeds) && !empty($hair_seeds)) {
            foreach ($hair_seeds as $hair_key => $hair_val) {
                hair_master::create($hair_val);
            }
        }
    }
}
