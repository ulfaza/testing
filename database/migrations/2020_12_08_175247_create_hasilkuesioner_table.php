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
            $table->integer('sk_id')->unsigned();
            $table->integer('hk_nilai');
        });
        Schema::table('hasilkuesioner', function($table){
            $table->foreign('sk_id')
                ->references('sk_id')
                ->on('subkarakteristik')
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
