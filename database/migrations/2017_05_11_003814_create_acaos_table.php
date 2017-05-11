<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acao', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao');
            $table->string('nome')->unique();
            $table->integer('mod_id')->unsigned();
            $table->foreign('mod_id')->references('id')->on('modulo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acao');
    }
}
