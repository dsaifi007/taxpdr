<?php

use Illuminate\Database\Seeder;

class PropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('property_types')->insert([			
			['name' => 'Residential','status'=>'1'],
			['name' => 'Commercial','status'=>'1'],					
		]);
    }
}
