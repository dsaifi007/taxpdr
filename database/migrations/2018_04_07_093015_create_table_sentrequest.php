<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSentrequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('sent_requests', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->foreign('request_user_id')->references('id')->on('users')->onDelete('cascade');
                $table->integer('property_id');
                $table->integer('valuer_id')->nullable()->comment('assign  valuer id');
                $table->integer('request_status')->default(1);
                 $table->string('report_name')->nullable();
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
         Schema::dropIfExists('sent_requests');
    }
}
