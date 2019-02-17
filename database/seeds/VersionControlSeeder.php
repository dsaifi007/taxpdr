<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class VersionControlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
         DB::table('version_control')->insert([			
			['name' => '1','os_type'=>'android'],
			['name' => '1','os_type'=>'apple'],
			['name' => '1.1','code'=>'android'], 
			['name' => '1.1','code'=>'apple'],
			['name' => '2','code'=>'android'],
			['name' => '2','code'=>'apple']
					
		]);
    }
}



