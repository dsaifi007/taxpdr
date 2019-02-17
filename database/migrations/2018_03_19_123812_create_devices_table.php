<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('clientid')->unsigned();
            $table->string('appname')->nullable();
            $table->string('appversion')->nullable();
            $table->string('deviceuid')->nullable();
            $table->string('devicetoken')->nullable();
            $table->string('devicename')->nullable();
            $table->string('devicemodel')->nullable();
            $table->string('deviceversion')->nullable();
            $table->string('os_type')->nullable();
            $table->enum('status',['active','uninstalled'])->default('active');
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
        Schema::dropIfExists('devices');
    }
}
