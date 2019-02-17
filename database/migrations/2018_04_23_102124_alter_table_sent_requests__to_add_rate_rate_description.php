<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableSentRequestsToAddRateRateDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sent_requests', function($table) {
        $table->integer('rate')->after('report_name')->nullable();
        $table->string('review_description')->after('rate')->nullable();
        $table->enum('report_view_status',['0','1'])->after('review_description')->default('0');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sent_requests', function($table) {
        $table->dropColumn('rate');
        $table->dropColumn('review_description');
        $table->dropColumn('report_view_status');
    });
    }
}
