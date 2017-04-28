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

}
