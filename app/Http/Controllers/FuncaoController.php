<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Funcao;
use Illuminate\Http\Request;

class FuncaoController extends Controller
{


    public function __construct() {
        $this->middleware('auth');
    }

    protected function inicio(Request $request, $id_empresa = 0)
    {

        $empresas = Empresa::all();

        if ($empresas->count() <= 0) {
            return redirect('/empresa/create');
        }

        if ($id_empresa == 0) {
            $id_empresa = $empresas->first()->id;
        }

        $funcoes = Funcao::where('emp_id', $id_empresa)->get();

        if ($request->ajax()) {
            return $funcoes;
        }

        return view('funcao.index', compact('funcoes', 'empresas', 'id_empresa'));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id_empresa = 0)
    {
        return $this->inicio($request, $id_empresa);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $funcao = new Funcao();
        $empresas = Empresa::all();

        return view('funcao.edit', compact('funcao', 'empresas'));
    }

    private function validar(Request $request) {
        $this->validate($request, [
            'nome' => 'required',
            'emp_id' => 'required'
        ] ,
        [
            'nome.required' => 'O nome da Função é obrigatório',
            'emp_id.required' => 'A empresa é obrigatória'
        ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validar($request);

        $funcao = new Funcao();
        $funcao->nome = $request->nome;
        $funcao->emp_id = $request->emp_id;
        $funcao->save();

        return redirect()->action('FuncaoController@index', ['id_empresa'=> $request->emp_id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $funcao = Funcao::findOrFail($id);
        $empresas = Empresa::all();

        return view('funcao.edit', compact('funcao', 'empresas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validar($request);

        $funcao = Funcao::findOrFail($id);

        $funcao->update($request->all());

        return redirect()->action('FuncaoController@index', ['id_empresa'=> $funcao->emp_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $funcao_deleted = Funcao::findOrFail($id);

        $funcao_deleted->delete();

        session()->flash('funcao_deleted', $funcao_deleted);

        return redirect()->action('FuncaoController@index', ['id_empresa' => $funcao_deleted->emp_id]);
    }

    public function restore($id)
    {

        $funcao = Funcao::onlyTrashed()->where('id','=',$id)->firstOrFail();
        $funcao->restore();

        return redirect()->action('FuncaoController@index', ['id_empresa' => $funcao->emp_id]);

    }
}
