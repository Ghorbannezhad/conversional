<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sessions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create sessions table
        Schema::create('sessions', function (Blueprint $table){
           $table->increments('id');
           $table->integer('user_id')->unsigned();
           $table->timestamp('activated')->nullable();
           $table->timestamp('appointment')->nullable();
        });

        //Add relation to user table and set engine to InnoDB
        Schema::table('sessions', function (Blueprint $table){
            $table->foreign('user_id', 'user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sessions');
    }
}
