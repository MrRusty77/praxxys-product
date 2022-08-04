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
            $table->unsignedBigInteger('users_id')->references('id')->on('users');
            $table->text('code')->nullable(true);
            $table->text('hash')->nullable(true);
            $table->float('total_amount', 100, 2)->default(0);
            $table->integer('total_items')->default(0);
            $table->string('payment_status', 7)->default('pending');
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
