<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKarakteristikaplikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karakteristikaplikasi', function (Blueprint $table) {
            $table->increments('ka_id')->unique();
            $table->integer('a_id')->unsigned();
            $table->integer('k_id')->unsigned();
            $table->string('ka_nama');
            $table->decimal('ka_bobot',8,2);
            $table->decimal('ka_nilai',8,2);
        });
        Schema::table('karakteristikaplikasi', function($table){
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
        Schema::dropIfExists('karakteristikaplikasi');
    }
}
