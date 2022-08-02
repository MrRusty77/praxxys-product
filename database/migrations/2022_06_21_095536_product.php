<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->string('hash', 255)->unique();
            $table->string('code', 255)->unique();
            $table->float('price', 255)->default(1);
            $table->integer('category_id')->unsigned()->references('id')->on('categories');
            $table->text('description')->nullable();
            $table->dateTime('date_and_time')->nullable();
            $table->string('status', 16)->default('active');
            $table->timestamps();
        });
        Schema::table('product', function (Blueprint $table) {
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
