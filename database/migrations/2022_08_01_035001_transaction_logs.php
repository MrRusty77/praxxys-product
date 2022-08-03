<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TransactionLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_logs', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('transaction_id');
            // $table->foreign('transaction_id')->references('id')->on('transations')->constrained()->onDelete('cascade');
            $table->bigInteger('transaction_id')->unsigned()->references('id')->on('transations');
            $table->bigInteger('product_id')->unsigned()->references('id')->on('products');
            
            // $table->unsignedBigInteger('product_id');
            // $table->foreign('product_id')->references('id')->on('products')->constrained()->onDelete('cascade');
            $table->integer('qty')->default(0);
            $table->float('price', 100, 2)->default(1);
            $table->float('total_price', 100, 2)->default(1);
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
