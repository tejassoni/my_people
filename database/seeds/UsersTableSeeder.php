<?php

use App\User;
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
        User::query()->truncate(); // truncate user table each time of seeders run
        User::create([ // create a new user values
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'f_name' => 'Administrator',
            'm_name' => 'm_admin',
            'l_name' => 'l_admin',
        ]);
    }
}
