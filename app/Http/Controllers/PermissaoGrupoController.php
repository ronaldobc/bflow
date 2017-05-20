<?php

namespace App\Http\Controllers;

use App\Acao;
use App\Empresa;
use App\Grupo;
use App\Modulo;
use Illuminate\Http\Request;

class PermissaoGrupoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_grupo=0)
    {

        $grupos = Grupo::all();
        if ($grupos->count() <= 0) {
            return redirect('/grupo/create');
        }

        if ($id_grupo == 0) {
            $id_grupo = $grupos->first()->id;
        }

        $grupo = Grupo::find($id_grupo);
        $modulos = Modulo::all();

        return view('permissao.grupo', compact('grupos', 'id_grupo', 'grupo', 'modulos'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_grupo)
    {
        $modulos = $request['perm_modulo'];
        $acoes = $request['perm_acao'];

        //valida se o modulo da acao foi selecionado, senao seleciona
        foreach ($acoes as $acao_id) {
            $acao = Acao::find($acao_id);
            if (in_array($acao->mod_id, $modulos)==false) {
                $modulos[] = $acao->mod_id;
            }
        }

        $grupo = Grupo::find($id_grupo);
        $grupo->modulos()->sync($modulos);
        $grupo->acoes()->sync($acoes);

        return redirect()->action('PermissaoGrupoController@index', ['id'=> $id_grupo]);

    }


}
