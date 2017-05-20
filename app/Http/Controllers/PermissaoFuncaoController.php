<?php

namespace App\Http\Controllers;

use App\Acao;
use App\Funcao;
use App\Modulo;
use Illuminate\Http\Request;

class PermissaoFuncaoController extends Controller
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
    public function index($id_funcao=0)
    {
        $funcoes = Funcao::all();
        if ($funcoes->count() <= 0) {
            return redirect('/funcao/create');
        }

        if ($id_funcao == 0) {
            $id_funcao = $funcoes->first()->id;
        }

        $funcao = Funcao::find($id_funcao);
        $modulos = Modulo::all();

        return view('permissao.funcao', compact('funcoes', 'id_funcao', 'funcao', 'modulos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_funcao)
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

        $funcao = Funcao::find($id_funcao);
        $funcao->modulos()->sync($modulos);
        $funcao->acoes()->sync($acoes);

        return redirect()->action('PermissaoFuncaoController@index', ['id'=> $id_funcao]);
    }

 }
