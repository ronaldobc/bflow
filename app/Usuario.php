<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    public $diretorio_foto = "img\\usuario";

    protected $table = 'usuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFotoPathAttribute() {
        return '\\' . $this->diretorio_foto . '\\' . $this->foto;
    }

    public function grupos()
    {
        return $this->belongsToMany('App\Grupo','grupo_usuarios','usu_id');
    }

    public function departamentos()
    {
        return $this->hasMany('App\UsuarioDepartamento','usu_id');
    }

    public function departamentosAtuais($emp_id = 0)
    {
        if ($emp_id == 0) {
            return $this->departamentos()->whereNull('fim')->get();

        } else {
            return $this->departamentos()->join('departamento', 'usuario_dep.dep_id', '=', 'departamento.id')
                                         ->whereNull('fim')
                                         ->where('emp_id',$emp_id)->get();
        }
    }

    public function funcoes()
    {
        return $this->hasMany('App\UsuarioFuncao','usu_id');
    }

    public function funcoesAtuais($emp_id = 0)
    {
        if ($emp_id == 0) {
            return $this->funcoes()->whereNull('fim')->get();

        } else {
            return $this->funcoes()->join('funcao', 'usuario_funcao.func_id', '=', 'funcao.id')
                ->whereNull('fim')
                ->where('emp_id',$emp_id)->get();
        }
    }

}
