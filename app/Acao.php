<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acao extends Model
{
    protected $table = 'acao';

    public function modulo()
    {
        return $this->belongsTo('App\Modulo', 'mod_id');
    }

    public function grupos()
    {
        return $this->morphToMany('App\Grupo', 'obj', 'permissao_grupo', 'grupo_id');
    }

}
