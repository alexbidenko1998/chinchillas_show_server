<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChinchillaAdminComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chinchilla_color_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('timestamp');
            $table->text('content');
            $table->bigInteger('chinchilla_id');
        });
        Schema::table('chinchillas', function (Blueprint $table) {
            $table->string('conclusion', 10)->default('not_check');
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
