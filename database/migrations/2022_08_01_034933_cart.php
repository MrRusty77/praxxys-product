<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->references('id')->on('users');
            $table->bigInteger('product_id')->unsigned()->references('id')->on('products');
            // $table->unsignedBigInteger('user_id');
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->unsignedBigInteger('product_id');
            // $table->foreign('product_id')->references('id')->on('product');
            $table->integer('qty')->default(0);
            $table->string('status', 16)->default('active');
            $table->timestamps();
        });

        Schema::table('cart', function (Blueprint $table) {
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
