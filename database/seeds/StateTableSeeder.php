<?php

use App\Models\state_master;
use Illuminate\Database\Seeder;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        //Add this lines
        state_master::query()->truncate(); // truncate user table each time of seeders run
        $state_seeds = config('state_seeds.states');     
        if (isset($state_seeds) && !empty($state_seeds)) {
            foreach ($state_seeds as $state_key => $state_val) {
                state_master::create($state_val);
            }
        }
    }
}
