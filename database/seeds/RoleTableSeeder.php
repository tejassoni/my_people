<?php

use App\Models\role_master;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add this lines
        role_master::query()->truncate(); // truncate role table each time of seeders run
        $role_seeds = config('role_seeds.roles');
        if (isset($role_seeds) && !empty($role_seeds)) {
            foreach ($role_seeds as $role_key => $role_val) {
                role_master::create($role_val);
            }
        }
    }
}
