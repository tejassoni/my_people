<?php

use App\Models\eyebrow_master;
use Illuminate\Database\Seeder;

class EyeBrowTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add this lines
        eyebrow_master::query()->truncate(); // truncate eyebrow table each time of seeders run
        $eyebrow_seeds = config('eyebrow_seeds.eyebrows');
        if (isset($eyebrow_seeds) && !empty($eyebrow_seeds)) {
            foreach ($eyebrow_seeds as $eyebrow_key => $eyebrow_val) {
                eyebrow_master::create($eyebrow_val);
            }
        }
    }
}
