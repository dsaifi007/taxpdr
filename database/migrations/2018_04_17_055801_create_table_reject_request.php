<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRejectRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rejected_request_users', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->foreign('reject_user_id')->references('id')->on('users')->onDelete('cascade');
                $table->integer('sent_request_id');
                $table->softDeletes();
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
        Schema::dropIfExists('rejected_request_users');
    }
}
