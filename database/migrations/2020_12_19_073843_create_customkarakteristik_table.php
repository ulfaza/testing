<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomkarakteristikTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customkarakteristik', function (Blueprint $table) {
            $table->increments('ck_id')->unique();
            $table->integer('a_id')->unsigned();
            $table->string('ck_nama');
            $table->decimal('ck_bobot',8,2);
            $table->decimal('ck_nilai',8,2);
        });
        Schema::table('customkarakteristik', function($table){
            $table->foreign('a_id')
                ->references('a_id')
                ->on('aplikasi')
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
