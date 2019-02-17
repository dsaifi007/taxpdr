<?php

use Illuminate\Database\Seeder;

class StatesListsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('states')->insert([			
			['name' => 'New South Wales','status'=>'1'],
			['name' => 'Queensland','status'=>'1'],
			['name' => 'South Australia','status'=>'1'], 
			['name' => 'Tasmania','status'=>'1'],
			['name' => 'Victoria','status'=>'1'],
			['name' => 'Western Australia','status'=>'1']
					
		]);
    }
}
