<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Images extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->text('path')->nullable();
            // $table->integer('product_id');
            $table->string('product_hash', 255);
            $table->string('status', 16)->default('active');
            $table->timestamps();
        });

        Schema::table('images', function (Blueprint $table) {
            $table->integer('product_id')->unsigned()->references('id')->on('product');
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
