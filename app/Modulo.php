<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = 'modulo';

    public function acoes()
    {
        return $this->hasMany('App\Acao', 'mod_id');
    }

    public function grupos()
    {
        return $this->morphToMany('App\Grupo', 'obj', 'permissao_grupo', 'obj_id', 'grupo_id');
    }
}
