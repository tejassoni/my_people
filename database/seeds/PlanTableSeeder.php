<?php

use App\Models\plan_master;
use Illuminate\Database\Seeder;

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add this lines
        plan_master::query()->truncate(); // truncate discount table each time of seeders run
        $plan_seeds = config('plan_seeds.plans');
        if (isset($plan_seeds) && !empty($plan_seeds)) {
            foreach ($plan_seeds as $plan_key => $plan_val) {
                plan_master::create($plan_val);
            }
        }
    }
}
