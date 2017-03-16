<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioDepartamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_dep', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('usu_id');
            $table->integer('dep_id');
            $table->dateTime('inicio');
            $table->dateTime('fim');
            $table->integer('usu_gerente');
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
        Schema::dropIfExists('usuario_dep');
    }
}
