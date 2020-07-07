<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChinchillaPhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('chinchilla_photos', function(Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('chinchilla_id');
        $table->string('name', 40);
      });
      Schema::table('chinchillas', function(Blueprint $table) {
        $table->bigInteger('avatar_id');
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
