<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioFuncao extends Model
{
    protected $table = 'usuario_funcao';

    public function funcao()
    {
        return $this->belongsTo('App\Funcao', 'func_id');
    }
}
