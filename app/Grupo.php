<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grupo extends Model
{
    use SoftDeletes;

    protected $table = 'grupo';
    protected $fillable = ['nome', 'emp_id'];

    public function empresa()
    {
        return $this->belongsTo('App\Empresa', 'emp_id');
    }

    public function usuarios()
    {
        return $this->belongsToMany('App\Usuario','grupo_usuarios','grupo_id', 'usu_id');
    }

}
