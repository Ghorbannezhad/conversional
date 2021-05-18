<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvoiceDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create invoice detail table
        Schema::create('invoice_details', function (Blueprint $table){

           $table->increments('id');
           $table->integer('invoice_id')->unsigned();
           $table->integer('user_id')->unsigned();
           $table->tinyInteger('type');
           $table->float('price');
           $table->integer('appointment_count');
           $table->integer('activated_count');
           $table->timestamp('created_at');
           $table->softDeletes();

        });

        Schema::table('invoice_details', function (Blueprint $table){
           $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
           $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('invoice_details');
    }
}
