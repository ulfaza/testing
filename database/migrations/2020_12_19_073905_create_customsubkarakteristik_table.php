<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomsubkarakteristikTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customsubkarakteristik', function (Blueprint $table) {
            $table->increments('cs_id')->unique();
            $table->integer('ck_id')->unsigned();
            $table->string('cs_nama');
            $table->decimal('cs_bobot',8,2);
            $table->decimal('bobot_absolut',8,2);
            $table->decimal('nilai_subfaktor',8,2);
            $table->decimal('nilai_absolut',8,2);
        });
        Schema::table('customsubkarakteristik', function($table){
            $table->foreign('ck_id')
                ->references('ck_id')
                ->on('customkarakteristik')
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
