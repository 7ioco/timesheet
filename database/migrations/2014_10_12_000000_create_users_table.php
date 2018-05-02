<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            /** New field added by Chiranjib **/
            $table->integer('user_type_id');
            $table->string('position')->nullable();
            $table->float('client_rate')->nullable();
            $table->float('normal_rate')->nullable();
            $table->float('ot_rate')->nullable();
            $table->float('normal_hours')->nullable();
            $table->tinyInteger('ot_eligible')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('city')->nullable();
            $table->float('state')->nullable();
            $table->float('country')->nullable();
            $table->float('postal_code')->nullable();
              
            /** end field addedd **/
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
        Schema::dropIfExists('users');
    }
}
