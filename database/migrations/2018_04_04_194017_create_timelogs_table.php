<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimelogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timelogs', function (Blueprint $table) {
            $table->softDeletes();
            $table->increments('id');
            $table->integer('task_id');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->integer('total_time')->default(0);
            $table->boolean('active')->default(1);
            $table->string('comment')->default('');
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
        Schema::drop('timelogs');
    }
}
