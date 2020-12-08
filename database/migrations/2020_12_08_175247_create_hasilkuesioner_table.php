<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHasilkuesionerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasilkuesioner', function (Blueprint $table) {
            $table->integer('sa_id')->unsigned();
            $table->integer('hk_nilai');
        });
        Schema::table('hasilkuesioner', function($table){
            $table->foreign('sa_id')
                ->references('sa_id')
                ->on('subkarakteristikaplikasi')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hasilkuesioner');
    }
}
