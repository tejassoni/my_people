<?php

use App\Models\lip_master;
use Illuminate\Database\Seeder;

class LipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add this lines
        lip_master::query()->truncate(); // truncate lip table each time of seeders run
        $lip_seeds = config('lip_seeds.lips');
        if (isset($lip_seeds) && !empty($lip_seeds)) {
            foreach ($lip_seeds as $lip_key => $lip_val) {
                lip_master::create($lip_val);
            }
        }
    }
}
