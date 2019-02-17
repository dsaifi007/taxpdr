<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSavedCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saved_card', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->foreign('saved_card_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('stripe_card_id')->nullable();
            $table->string('brand')->nullable();
            $table->string('card_number',20);
            $table->integer('card_exp_month');
            $table->integer('card_exp_year');
			$table->enum('default_status',['0','1'])->default('0');
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
        Schema::dropIfExists('saved_card');
    }
}
