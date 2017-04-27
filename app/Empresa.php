<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{

    use SoftDeletes;

    protected $table = 'empresa';

    public function departamentos() {
        return $this->hasMany('App\Departamento', 'emp_id');
    }
}
