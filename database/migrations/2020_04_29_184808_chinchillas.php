<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Chinchillas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chinchillas', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status', 10);
            $table->boolean('is_ready');
            $table->bigInteger('birthday');
            $table->string('sex', 1);
            $table->bigInteger('user_id')->nullable();
            $table->text('weight')->nullable();
            $table->text('brothers')->nullable();
            $table->text('awards')->nullable();
            $table->text('description')->nullable();
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
