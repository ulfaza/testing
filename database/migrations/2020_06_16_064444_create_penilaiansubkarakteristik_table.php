<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenilaiansubkarakteristikTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaiansubkarakteristik', function (Blueprint $table) {
            $table->increments('ps_id')->unique();
            $table->integer('pk_id')->unsigned();
            $table->integer('sk_id')->unsigned();
            $table->integer('jml_responden')->unsigned();
            $table->integer('total_per_sub')->unsigned();
            $table->float('bobot_absolut');
            $table->float('nilai_subfaktor');
            $table->float('nilai_absolut');
        });
        Schema::table('penilaiansubkarakteristik', function($table){
            $table->foreign('pk_id')
                ->references('pk_id')
                ->on('penilaiankarakteristik')
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
        Schema::dropIfExists('penilaiansubkarakteristik');
    }
}
