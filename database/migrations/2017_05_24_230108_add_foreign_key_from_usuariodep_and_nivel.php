<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyFromUsuariodepAndNivel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usuario_dep', function (Blueprint $table) {
            $table->foreign('nivel_id')->references('id')->on('nivel');
            $table->foreign('usu_id')->references('id')->on('usuario');
            $table->foreign('dep_id')->references('id')->on('departamento');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usuario_dep', function (Blueprint $table) {
            $table->dropForeign(['nivel_id']);
            $table->dropForeign(['usu_id']);
            $table->dropForeign(['dep_id']);
        });
    }
}
