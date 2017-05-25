<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grupo extends Model
{
    use SoftDeletes;

    protected $table = 'grupo';
    protected $fillable = ['nome', 'emp_id'];

    public function getNomeComEmpresaAttribute()
    {
        return $this->nome . ' ['.$this->empresa->nome.']';
    }

    public function empresa()
    {
        return $this->belongsTo('App\Empresa', 'emp_id');
    }

    public function usuarios()
    {
        return $this->belongsToMany('App\Usuario','grupo_usuarios','grupo_id', 'usu_id');
    }

    public function modulos()
    {
        return $this->morphedByMany('App\Modulo','obj','permissao_grupo', 'grupo_id');
    }

    public function acoes() {
        return $this->morphedByMany('App\Acao','obj','permissao_grupo', 'grupo_id');
    }
}
