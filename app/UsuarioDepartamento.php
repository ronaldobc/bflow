<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioDepartamento extends Model
{
    protected $table = 'usuario_dep';
    protected $dates = ['inicio', 'fim'];

    public function nivel()
    {
        return $this->belongsTo('App\Nivel','nivel_id');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Usuario', 'usu_id');
    }

    public function departamento()
    {
        return $this->belongsTo('App\Departamento', 'dep_id');
    }

}
