<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSavedAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saved_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id')->unsigned();
            $table->integer('user_id')->unsigned()->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
            $table->decimal('calculate_price',10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saved_addresses');
    }
}
