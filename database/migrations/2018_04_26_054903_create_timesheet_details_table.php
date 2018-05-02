<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimesheetDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheet_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('timesheet_id');
            $table->time('start_time');
            $table->time('end_time');
            $table->float('break_hours');
            $table->float('decimal_duration');
            $table->string('apn_no');
            $table->string('task_no');
            $table->string('plc_no');
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
        Schema::dropIfExists('timesheet_details');
    }
}
