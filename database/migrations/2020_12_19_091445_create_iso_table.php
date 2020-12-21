<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIsoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('iso', function (Blueprint $table) {
            $table->increments('iso_id')->unique();
            $table->integer('a_id')->unsigned();
            $table->integer('k_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('iso', function($table){
            $table->foreign('a_id')
                ->references('a_id')
                ->on('aplikasi')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('iso', function($table){
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
        //
    }
}
