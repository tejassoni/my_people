<?php

use App\Models\jaw_master;
use Illuminate\Database\Seeder;

class JawTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add this lines
        jaw_master::query()->truncate(); // truncate jaw table each time of seeders run
        $jaw_seeds = config('jaw_seeds.jaws');
        if (isset($jaw_seeds) && !empty($jaw_seeds)) {
            foreach ($jaw_seeds as $jaw_key => $jaw_val) {
                jaw_master::create($jaw_val);
            }
        }
    }
}
