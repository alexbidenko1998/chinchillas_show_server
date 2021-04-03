<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChinchillaPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->bigInteger('chinchilla_id');
        });
        DB::table('prices')->get()->each(function ($item) {
            DB::table('prices')->where('id', $item->id)->update([
                'chinchilla_id' => DB::table('statuses')->where('id', $item->status_id)->first()->chinchilla_id
            ]);
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
