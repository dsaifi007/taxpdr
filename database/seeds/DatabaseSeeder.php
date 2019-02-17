<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(RolesSeeder::class);
         $this->call(CountrySeeder::class);
         $this->call(VersionControlSeeder::class);
         $this->call(PropertyTypeSeeder::class);
         $this->call(StatesListsSeeder::class);
         $this->call(ProgressStatusSeeder::class);
         
    }
}
