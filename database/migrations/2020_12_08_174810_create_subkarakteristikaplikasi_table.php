<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubkarakteristikaplikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subkarakteristikaplikasi', function (Blueprint $table) {
            $table->increments('sa_id')->unique();
            $table->integer('ka_id')->unsigned();
            $table->integer('sk_id')->unsigned();
            $table->string('sa_nama');
            $table->decimal('sa_bobot',8,2);
            $table->decimal('bobot_absolut',8,2);
            $table->decimal('nilai_subfaktor',8,2);
            $table->decimal('nilai_absolut',8,2);
        });
        Schema::table('subkarakteristikaplikasi', function($table){
            $table->foreign('ka_id')
                ->references('ka_id')
                ->on('karakteristikaplikasi')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('subkarakteristikaplikasi');
    }
}
