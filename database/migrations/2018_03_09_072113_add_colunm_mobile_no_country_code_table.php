<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColunmMobileNoCountryCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
         Schema::table('users', function($table) {
           $table->string('country_code')->after('account_type');
           $table->string('mobile_no')->after('country_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('users', function($table) {
                 $table->dropColumn('country_code');
                 $table->dropColumn('mobile_no');

        });
    }
}
