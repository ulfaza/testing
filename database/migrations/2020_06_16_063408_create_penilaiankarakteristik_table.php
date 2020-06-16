<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenilaiankarakteristikTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaiankarakteristik', function (Blueprint $table) {
            $table->increments('pk_id')->unique();
            $table->integer('a_id')->unsigned();
            $table->integer('k_id')->unsigned();
            $table->float('pk_nilai');
        });
        Schema::table('penilaiankarakteristik', function($table){
            $table->foreign('a_id')
                ->references('a_id')
                ->on('aplikasi')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('k_id')
                ->references('k_id')
                ->on('karakteristik')
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
        Schema::dropIfExists('penilaiankarakteristik');
    }
}
