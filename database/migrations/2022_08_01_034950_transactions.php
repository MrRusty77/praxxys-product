<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->float('total_purchase', 100, 2)->default(0);
            $table->int('card_number', 16);
            $table->int('expiry_month', 2);
            $table->int('expiry_year', 4);
            $table->int('cvv', 3);
            $table->string('payment_status', 6)->default('failed');
            $table->dateTime('date_purchased')->nullable(true);
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
