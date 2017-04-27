<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{
    use SoftDeletes;

    protected $table = 'departamento';
    protected $fillable = ['nome', 'dep_cd_pai', 'emp_id'];

    public function empresa() {
        return $this->belongsTo('App\Empresa','emp_id');
    }

    public function departamentoPai() {
        return $this->belongsTo('App\Departamento', 'dep_cd_pai');
    }

}
