<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalculatorSearchInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('calculator_search_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->foreign('customers_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('property_type');
            $table->integer('construction_year');
            $table->integer('purchase_year');
            $table->enum('property_new_status',['yes','no'])->default('yes');
            $table->decimal('purchase_price',10, 2);
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
        Schema::dropIfExists('calculator_search_info');
    }
}
