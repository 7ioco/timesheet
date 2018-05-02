<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimesheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->integer('user_id');
            $table->date('date');
            $table->float('client_rate');
            $table->float('normal_rate');
            $table->tinyInteger('ot_eligible');
            $table->float('ot_rate');
            $table->float('normal_hours');
            $table->integer('entered_by');
            $table->integer('verified');
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
        Schema::dropIfExists('timesheets');
    }
}
