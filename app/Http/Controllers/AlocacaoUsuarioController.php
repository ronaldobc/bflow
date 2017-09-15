<?php

namespace App\Http\Controllers;

use App\Departamento;
use App\Empresa;
use App\Funcao;
use App\Nivel;
use App\Usuario;
use App\UsuarioDepartamento;
use App\UsuarioFuncao;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AlocacaoUsuarioController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function index()
//    {
//        //
//    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function create()
//    {
//        //
//    }

    private function validarUserDep(Request $request) {
        $this->validate($request,
            [
                'dep_id' => 'required',
                'nivel_id' => 'required'
            ],
            [
                'dep_id.required' => 'O departamento é obrigatório',
                'nivel_id.required' => 'O nível de hierarquia é obrigatório'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storedep(Request $request, $id)
    {
        //dd($request);

        $this->validarUserDep($request);

        //verifica finalizar atuais da empresa
        if ($request['finaliza_atual']) {
            $deptos = Departamento::where('emp_id', $request['emp_id'])->select('id')->get();

            //dd($deptos->pluck('id'));

            $user_dep = UsuarioDepartamento::where('usu_id',$id)->where('fim', null)->whereIn('dep_id', $deptos->pluck('id'))->get();
            //dd($user_dep);

            foreach($user_dep as $u) {
                $u->fim = Carbon::now();
                $u->save();
            }

        }

        //verifica finalizar atuais de outras empresas
        if ($request['finaliza_outras']) {
            $deptos = Departamento::where('emp_id', '<>', $request['emp_id'])->select('id')->get();

            //dd($deptos->pluck('id'));

            $user_dep = UsuarioDepartamento::where('usu_id',$id)->where('fim', null)->whereIn('dep_id', $deptos->pluck('id'))->get();
            //dd($user_dep);

            foreach($user_dep as $u) {
                $u->fim = Carbon::now();
                $u->save();
            }

        }

        //cria novo UsuarioDepartamento
        $ud = new UsuarioDepartamento();
        $ud->usu_id = $id;
        $ud->dep_id = $request['dep_id'];
        $ud->inicio = Carbon::now();
        $ud->nivel_id = $request['nivel_id'];
        $ud->save();

        return redirect()->action('AlocacaoUsuarioController@show', ['id_empresa' => $request['emp_id'], 'id' => $id, 'aba'=>'dep']);

    }

    public function storefunc(Request $request, $id)
    {
        //dd($request);

        $this->validarUserFunc($request);

        //verifica finalizar atuais da empresa
        if ($request['finaliza_atual_func']) {
            $funcoes = Funcao::where('emp_id', $request['emp_id'])->select('id')->get();

            $user_func = UsuarioFuncao::where('usu_id',$id)->where('fim', null)->whereIn('func_id', $funcoes->pluck('id'))->get();

            foreach($user_func as $u) {
                $u->fim = Carbon::now();
                $u->save();
            }

        }

        //verifica finalizar atuais de outras empresas
        if ($request['finaliza_outras_func']) {
            $funcoes = Funcao::where('emp_id', '<>', $request['emp_id'])->select('id')->get();

            $user_func = UsuarioFuncao::where('usu_id',$id)->where('fim', null)->whereIn('func_id', $funcoes->pluck('id'))->get();

            foreach($user_func as $u) {
                $u->fim = Carbon::now();
                $u->save();
            }

        }

        //cria novo UsuarioFuncao
        $ud = new UsuarioFuncao();
        $ud->usu_id = $id;
        $ud->func_id = $request['func_id'];
        $ud->inicio = Carbon::now();
        $ud->save();

        return redirect()->action('AlocacaoUsuarioController@show', ['id_empresa' => $request['emp_id'], 'id' => $id, 'aba'=>'func']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id, $id_empresa = 0)
    {
        $usuario = Usuario::findorfail($id);
        $empresas = Empresa::all();

        $aba = $request->query('aba', 'dep');

        if ($empresas->count() <=0 ) {
            return redirect('/empresa.create');
        }

        if ($id_empresa == 0) {
            $id_empresa = $empresas->first()->id;
        }

        $funcoes = Funcao::where('emp_id', $id_empresa)->get();
        $departamentos = Departamento::where('emp_id', $id_empresa)->get();
        $niveis = Nivel::all();

        //$usuario_dep = UsuarioDepartamento::where('usu_id', $id)->where('emp_id',$id_empresa)->get();
        //$usuario_func = UsuarioFuncao::where('usu_id', $id)->where('emp_id',$id_empresa)->get();

        $usuario_dep = UsuarioDepartamento::where('usu_id',$id)->whereHas('departamento.empresa',function($q) use ($id_empresa) { $q->where('emp_id', $id_empresa); })->get();
        $usuario_func = UsuarioFuncao::where('usu_id', $id)->whereHas('funcao.empresa', function($q) use ($id_empresa){ $q->where('emp_id',$id_empresa);})->get();

        return view('alocacao.index', compact('usuario', 'empresas', 'niveis', 'funcoes', 'id_empresa', 'usuario_dep', 'usuario_func', 'departamentos', 'aba'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function edit($id)
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function update(Request $request, $id)
//    {
//        //
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function destroy($id)
//    {
//        //
//    }

    public function finalizadep($id)
    {

        $user_dep = UsuarioDepartamento::findorfail($id);
        $user_dep->fim = Carbon::now();
        $user_dep->save();

        return redirect()->action('AlocacaoUsuarioController@show', ['id_empresa'=> $user_dep->departamento->emp_id, 'id'=>$user_dep->usu_id, 'aba'=>'dep']);

    }

    public function finalizafunc($id)
    {
        $user_func = UsuarioFuncao::findorfail($id);
        $user_func->fim = Carbon::now();
        $user_func->save();

        return redirect()->action('AlocacaoUsuarioController@show', ['id_empresa'=> $user_func->funcao->emp_id, 'id'=>$user_func->usu_id, 'aba'=>'func']);

    }

    private function validarUserFunc($request)
    {
        $this->validate($request,
            [
                'func_id' => 'required',
            ],
            [
                'func_id.required' => 'A função é obrigatória',
            ]
        );
    }
}
