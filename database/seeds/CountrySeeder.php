<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('countries')->insert([			
			['name' => 'Australia','code'=>'+61', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now() ],
			['name' => 'United States','code'=>'+1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now() ],['name' => 'India','code'=>'+91','created_at' => Carbon::now(), 'updated_at' => Carbon::now() ] 
			
		
		]);
    }
}
