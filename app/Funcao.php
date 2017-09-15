<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Funcao extends Model
{

    use SoftDeletes;

    protected $table = 'funcao';
    protected $fillable = ['nome', 'emp_id'];

    public function empresa()
    {
        return $this->belongsTo('App\Empresa', 'emp_id');
    }

    public function modulos()
    {
        return $this->morphedByMany('App\Modulo','obj','permissao_funcao', 'funcao_id');
    }

    public function acoes() {
        return $this->morphedByMany('App\Acao','obj','permissao_funcao', 'funcao_id');
    }

    public function usuariosFuncao() {
        return $this->hasMany('App\UsuarioFuncao', 'func_id');
    }

}
