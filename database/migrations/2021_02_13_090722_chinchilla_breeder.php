<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChinchillaBreeder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chinchillas', function (Blueprint $table) {
            $table->string('breeder_type', 10)->nullable();
        });
        $chinchillas = DB::table('chinchillas')->get();
        $chinchillas->each(function ($c) {
            DB::table('chinchillas')->where('id', $c->id)->update([
                'breeder_type' => 'owner',
                'breeder_id' => $c->owner_id,
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
