<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioFuncaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_funcao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('usu_id')->unsigned();
            $table->integer('func_id')->unsigned();
            $table->dateTime('inicio');
            $table->dateTime('fim')->nullable();
            $table->foreign('usu_id')->references('id')->on('usuario');
            $table->foreign('func_id')->references('id')->on('funcao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario_funcao');
    }
}
