<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('colors', function(Blueprint $table) {
            $table->string('standard', 10)->default('no')->change();
            $table->string('white', 10)->default('no')->change();
            $table->string('mosaic', 10)->default('no')->change();
            $table->string('beige', 10)->default('no')->change();
            $table->string('violet', 10)->default('no')->change();
            $table->string('sapphire', 10)->default('no')->change();
            $table->string('angora', 10)->default('no')->change();
            $table->string('ebony', 10)->default('no')->change();
            $table->string('velvet', 10)->default('no')->change();
            $table->string('pearl', 10)->default('no')->change();
            $table->string('california', 10)->default('no')->change();
            $table->string('rex', 10)->default('no')->change();
            $table->string('lova', 10)->default('no')->change();
            $table->string('german', 10)->default('no')->change();
            $table->string('blue', 10)->default('no')->change();
            $table->string('fur', 10)->default('no')->change();
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
