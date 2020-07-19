<?php

use App\Models\subscription_master;
use Illuminate\Database\Seeder;

class SubscriptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add this lines
        subscription_master::query()->truncate(); // truncate subscription table each time of seeders run
        $subscription_seeds = config('subscription_seeds.subscriptions');
        if (isset($subscription_seeds) && !empty($subscription_seeds)) {
            foreach ($subscription_seeds as $subscription_key => $subscription_val) {
                subscription_master::create($subscription_val);
            }
        }
    }
}
