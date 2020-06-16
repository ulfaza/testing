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
            $table->float('ps_bobot_relatif');
            $table->float('ps_nilai');
        });
        Schema::table('penilaiansubkarakteristik', function($table){
            $table->foreign('pk_id')
                ->references('k_id')
                ->on('penilaiankarakteristik')
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
