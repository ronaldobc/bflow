<?php

namespace App\Http\Controllers;

use App\Departamento;
use App\Empresa;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
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

        $departamentos = Departamento::where('emp_id', $id_empresa)->get();

        if ($request->ajax()) {
            return $departamentos;
        }

        return view('departamento.index', compact('departamentos', 'empresas', 'id_empresa'));

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
        $depto = new Departamento();
        $empresas = Empresa::all();
        $departamentos = collect(new Departamento());

        return view('departamento.edit', compact('depto', 'empresas', 'departamentos'));
    }


    private function validar(Request $request) {
        $this->validate($request,
            [
                'nome' => 'required',
                'emp_id' => 'required'
            ],
            [
                'nome.required' => 'O nome do Departamento é obrigatório',
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

        $depto = new Departamento();
        $depto->nome = $request->nome;
        $depto->emp_id = $request->emp_id;
        $depto->dep_cd_pai = $request->dep_cd_pai;
        $depto->save();

        return redirect()->action('DepartamentoController@index', ['id_empresa'=> $request->emp_id]);

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
        $depto = Departamento::findOrFail($id);
        $empresas = Empresa::all();
        $departamentos = collect(new Departamento());

        return view('departamento.edit', compact('depto', 'empresas', 'departamentos'));
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

        $depto = Departamento::findOrFail($id);

        $depto->update($request->all());

        return redirect()->action('DepartamentoController@index', ['id_empresa'=> $depto->emp_id]);

    }

    public function update_tree(Request $request, $id)
    {

        $depto = Departamento::findOrFail($id);

        $depto->update($request->all());

        return 'ok';

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $depto_deleted = Departamento::findOrFail($id);

        Departamento::where('dep_cd_pai', $id)->update(['dep_cd_pai'=>null]);

        $depto_deleted->delete();

        session()->flash('depto_deleted', $depto_deleted);

        return redirect()->action('DepartamentoController@index', ['id_empresa' => $depto_deleted->emp_id]);
    }

    public function restore($id)
    {

        $depto = Departamento::onlyTrashed()->where('id','=',$id)->firstOrFail();
        $depto->restore();

        return redirect()->action('DepartamentoController@index', ['id_empresa' => $depto->emp_id]);

    }


    private function tree_filho($id_depto) {
        $deptos = Departamento::where('dep_cd_pai', $id_depto)->get();
        $result = array();
        foreach($deptos as $depto) {
            $result[] = array('title'=>$depto->nome,
                'key' => $depto->id,
                'expanded' => true,
                'folder'=> false,
                'children' => $this->tree_filho($depto->id));
        }
        return $result;
    }

    public function tree($id_empresa = 0) {

        if ($id_empresa > 0) {
            $deptos = Departamento::where('dep_cd_pai', null)->where('emp_id', $id_empresa)->get();
        } else {
            $deptos = Departamento::where('dep_cd_pai', null)->get();
        }

        $result = array();

        foreach($deptos as $depto) {
            $result[] = array('title'=>$depto->nome,
                              'key' => $depto->id,
                              'expanded' => true,
                              'folder'=> false,
                              'children' => $this->tree_filho($depto->id));
        }

        return $result;

    }


}
