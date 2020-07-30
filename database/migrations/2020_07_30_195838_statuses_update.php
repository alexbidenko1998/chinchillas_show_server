<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StatusesUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $chinchillas = DB::table('chinchillas')->get();
        $statuses = DB::table('statuses')->get();
        Schema::table('statuses', function (Blueprint $table) {
            $table->bigInteger('chinchilla_id');
        });
        foreach ($chinchillas as $index => $chinchilla) {
            DB::table('statuses')->where('id', $statuses[$index]->id)->update([
                'chinchilla_id' => $chinchilla->id,
            ]);
        }
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
