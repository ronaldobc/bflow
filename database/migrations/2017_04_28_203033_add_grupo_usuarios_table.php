<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGrupoUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupo_usuarios', function (Blueprint $table) {
            $table->integer('grupo_id')->unsigned();
            $table->integer('usu_id')->unsigned();
            $table->foreign('grupo_id')->references('id')->on('grupo');
            $table->foreign('usu_id')->references('id')->on('usuario');
            $table->softDeletes();
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
        Schema::dropIfExists('grupo_usuarios');
    }
}
