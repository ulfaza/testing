<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubkarakteristikTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subkarakteristik', function (Blueprint $table) {
            $table->increments('sk_id')->unique();
            $table->integer('k_id')->unsigned();
            $table->string('sk_nama');
            $table->float('bobot_relatif');
        });
        Schema::table('subkarakteristik', function($table){
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
        Schema::dropIfExists('subkarakteristik');
    }
}
