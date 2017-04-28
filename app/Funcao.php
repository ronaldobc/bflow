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
}
