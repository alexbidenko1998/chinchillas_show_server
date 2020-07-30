<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChinchillaStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $chinchillas = DB::table('chinchillas')->get();
        Schema::table('chinchillas', function (Blueprint $table) {
            $table->dropColumn(['status']);
        });
        Schema::create('statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 10);
            $table->bigInteger('timestamp');
        });
        foreach ($chinchillas as $chinchilla) {
            DB::table('statuses')->insert([
                'name' => $chinchilla->status,
                'timestamp' => time() * 1000,
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
