<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurrentRoleColunmToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         
         Schema::table('users', function($table) {
           $table->integer('account_type')->unsigned()->after('api_token');
           //$table->foreign('current_role')->references('id')->on('roles');
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
                // $table->dropForeign(['current_role']);
                 $table->dropColumn('account_type');
        });
    }
}
