<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsIntoSentRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sent_requests', function($table){
            $table->integer('account_type')->nullable();
            $table->text('property_address');
            $table->string('suburb');
            $table->integer('property_type')->foreign('property_type')->references('id')->on('property_types')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('state');
            $table->integer('construction_year');
            $table->integer('purchase_year');
            $table->enum('property_new_status',['yes','no'])->default('yes');
            $table->bigInteger('purchase_price');
            $table->string('floor_area_unite')->nullable();
            $table->integer('floor_area')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sent_requests', function($table){
            $table->dropColumn('property_address');
            $table->dropColumn('suburb');
            $table->dropColumn('property_type');
            $table->dropColumn('state');
            $table->dropColumn('construction_year');
            $table->dropColumn('purchase_year');
            $table->dropColumn('property_new_status');
            $table->dropColumn('purchase_price');
            $table->dropColumn('floor_area_unite');
            $table->dropColumn('floor_area');
        });
    }
}
