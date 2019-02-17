<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->foreign('payment_user_id')->references('id')->on('users')->onDelete('cascade');
                $table->string('property_ids');
                $table->string('charge_id');
                $table->decimal('amount',10,2);
                $table->decimal('per_request_price',10,2);
                $table->string('transaction_status');
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
        Schema::dropIfExists('payment_transactions');
    }
}
