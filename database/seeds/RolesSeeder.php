<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('roles')->insert([			
			['name' => 'admin', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now() ],
			['name' => 'invester', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now() ],['name' => 'valuer', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now() ] 
			
		
		]);
    }
}
