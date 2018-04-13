<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColleagueRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colleague_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('colleague_id');
            $table->boolean('accepted')->default(0);
            $table->boolean('rejected')->default(0);
            $table->boolean('blocked')->default(0);
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
        Schema::dropIfExists('colleague_request');
    }
}
