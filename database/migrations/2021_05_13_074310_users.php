<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        //Create users table
        Schema::create('users', function (Blueprint $table){
           $table->increments('id');
           $table->string('email')->unique();
           $table->integer('customer_id')->unsigned();
           $table->integer('state')->nullable();
           $table->timestamps();

        });

        //Add relation to customer table and set engine to InnoDB
        Schema::table('users', function (Blueprint $table){
            $table->foreign('customer_id', 'customer')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
