<?php

use Illuminate\Database\Seeder;

class ProgressStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('progress_status')->insert([			
			['name' => 'Request Received'],
			['name' => 'Valuer Assigned'],
			['name' => 'Visit Scheduled'],
			['name' => 'Visit Completed'],
			['name' => 'Report Generated'],					
		]);
    }
}
