<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
          $table->increments('id');
            $table->integer('user_id')->unsigned()->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('property_address');
            $table->integer('property_type')->foreign('property_type')->references('id')->on('property_types')->onUpdate('cascade');;
            $table->string('suburb');
            $table->integer('state');
            $table->decimal('price',15,2);
			$table->integer('construction_year');
            $table->integer('purchase_year');
            $table->enum('property_new_status',['yes','no'])->default('yes');
            $table->bigInteger('purchase_price');
            $table->string('floor_area_unite')->nullable();
            $table->integer('floor_area')->nullable();
            $table->decimal('calculate_price',10, 2);
            $table->integer('progress_status')->default(0);
            $table->enum('payment_status',['0','1'])->default('0');
            $table->enum('status',['0','1'])->default('0');
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
        Schema::dropIfExists('properties');
    }
}
