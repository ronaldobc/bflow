<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioFuncao extends Model
{
    protected $table = 'usuario_funcao';
    protected $dates = ['inicio', 'fim'];

    public function funcao()
    {
        return $this->belongsTo('App\Funcao', 'func_id');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Usuario', 'usu_id');
    }
}
