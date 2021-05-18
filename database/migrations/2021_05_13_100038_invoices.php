<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Invoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create invoice table
        Schema::create('invoices', function (Blueprint $table){
           $table->increments('id');
           $table->integer('customer_id')->unsigned();
           $table->date('from');
           $table->date('to');
           $table->float('total_price')->default(0);
           $table->integer('total_appointment')->default(0);
           $table->integer('total_activated')->default(0);
           $table->integer('total_registered')->default(0);
           $table->timestamp('created_at');
           $table->softDeletes();
        });

        //Add relation to customer table and create unique collection to prevent invoice overlap
        Schema::table('invoices', function (Blueprint $table){
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('invoices');
    }
}
