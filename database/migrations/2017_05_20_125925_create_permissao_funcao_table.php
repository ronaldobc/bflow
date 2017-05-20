<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissaoFuncaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissao_funcao', function (Blueprint $table) {
            $table->integer('funcao_id')->unsigned();
            $table->foreign('funcao_id')->references('id')->on('funcao');
            $table->integer('obj_id')->unsigned();
            $table->string('obj_type');
            $table->unique(['funcao_id', 'obj_id', 'obj_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissao_funcao');
    }
}
