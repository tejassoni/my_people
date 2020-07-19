<?php

use App\Models\discount_master;
use Illuminate\Database\Seeder;

class DiscountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add this lines
        discount_master::query()->truncate(); // truncate discount table each time of seeders run
        $discount_seeds = config('discount_seeds.discounts');
        if (isset($discount_seeds) && !empty($discount_seeds)) {
            foreach ($discount_seeds as $discount_key => $discount_val) {
                discount_master::create($discount_val);
            }
        }
    }
}
