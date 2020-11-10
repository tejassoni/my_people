<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $this->call(UsersTableSeeder::class);
    $this->call(CountryTableSeeder::class);
    $this->call(StateTableSeeder::class);
    $this->call(CityTableSeeder::class);
    $this->call(CurrencyTableSeeder::class);
    $this->call(RoleTableSeeder::class);
    $this->call(EarTableSeeder::class);
    $this->call(EyeTableSeeder::class);
    $this->call(EyeBrowTableSeeder::class);
    $this->call(HairTableSeeder::class);
    $this->call(JawTableSeeder::class);
    $this->call(LipTableSeeder::class);
    $this->call(NoseTableSeeder::class);
    $this->call(SkinTableSeeder::class);
    $this->call(DiscountTableSeeder::class);
    $this->call(PlanTableSeeder::class);
    $this->call(SubscriptionTableSeeder::class);
  }
}
