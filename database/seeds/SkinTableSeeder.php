<?php

use App\Models\skin_master;
use Illuminate\Database\Seeder;

class SkinTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add this lines
        skin_master::query()->truncate(); // truncate skin table each time of seeders run
        $skin_seeds = config('skin_seeds.skins');
        if (isset($skin_seeds) && !empty($skin_seeds)) {
            foreach ($skin_seeds as $skin_key => $skin_val) {
                skin_master::create($skin_val);
            }
        }
    }
}
