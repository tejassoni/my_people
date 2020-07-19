<?php

use App\Models\currency_master;
use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add this lines
        currency_master::query()->truncate(); // truncate currency table each time of seeders run
        $currency_seeds = config('currency_seeds.currencies');
        if (isset($currency_seeds) && !empty($currency_seeds)) {
            foreach ($currency_seeds as $currency_key => $currency_val) {
                currency_master::create($currency_val);
            }
        }
    }
}
