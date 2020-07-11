<?php

use App\User;
use App\Models\user_master;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add this lines
        // User::query()->truncate(); // truncate user table each time of seeders run
        // User::create([ // create a new user values
        //     'email' => 'admin@admin.com',
        //     'password' => Hash::make('admin'),
        //     'f_name' => 'Administrator',
        //     'm_name' => 'm_admin',
        //     'l_name' => 'l_admin',
        // ]);

        //Add this lines
        user_master::query()->truncate(); // truncate user table each time of seeders run
        $user_seeds = config('user_seeds.users');
        if (isset($user_seeds) && !empty($user_seeds)) {
            foreach ($user_seeds as $user_key => $user_val) {
                if (isset($user_val['role_id']) && $user_val['role_id'] == 1) {
                    $user_val['password'] = Hash::make('Dilipkumar@1963');
                } elseif (isset($user_val['role_id']) && $user_val['role_id'] == 2) {
                    $user_val['password'] = Hash::make('Tejas@1989');
                } elseif (isset($user_val['role_id']) && $user_val['role_id'] == 3) {
                    $user_val['password'] = Hash::make('Vansh@2017');
                }
                $user_val['remember_token'] = Hash::make('Iamsuperconfidentchamp');
                user_master::create($user_val);
            }
        }
    }
}
