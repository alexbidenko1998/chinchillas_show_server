<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Colors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colors', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('chinchilla_id');
            $table->string('standard', 10)->nullable();
            $table->string('white', 10)->nullable();
            $table->string('mosaic', 10)->nullable();
            $table->string('beige', 10)->nullable();
            $table->string('violet', 10)->nullable();
            $table->string('sapphire', 10)->nullable();
            $table->string('angora', 10)->nullable();
            $table->string('ebony', 10)->nullable();
            $table->string('velvet', 10)->nullable();
            $table->string('pearl', 10)->nullable();
            $table->string('california', 10)->nullable();
            $table->string('rex', 10)->nullable();
            $table->string('lova', 10)->nullable();
            $table->string('german', 10)->nullable();
            $table->string('blue', 10)->nullable();
            $table->string('fur', 10)->nullable();
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
