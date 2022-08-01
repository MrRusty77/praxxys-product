<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PaymentResponse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_response', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('transaction_id');
            $table->bigInteger('transaction_id')->unsigned()->references('id')->on('transations');
            // $table->foreign('transaction_id')->references('id')->on('transations');
            $table->jsonb('response');
            $table->string('status', 16)->default('active');
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
        //
    }
}
