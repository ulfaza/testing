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
            $table->integer('ps_id')->unsigned();
            $table->integer('r_id')->unsigned();
            $table->float('hk_nilai');
        });
        Schema::table('hasilkuesioner', function($table){
            $table->foreign('ps_id')
                ->references('ps_id')
                ->on('penilaiansubkarakteristik')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('r_id')
                ->references('r_id')
                ->on('responden')
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
