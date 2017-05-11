<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Grupo;
use App\Usuario;
use Illuminate\Http\Request;

class GrupoController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    protected function inicio(Request $request, $id_empresa = 0)
    {

        $empresas = Empresa::all();


        if ($empresas->count() > 0) {
            if ($id_empresa == 0 ) {
                $id_empresa = $empresas->first()->id;
            }

            $grupos = Grupo::where('emp_id',$id_empresa)->get();

            //if ($grupos->count() > 0) {
                return view('grupo.index', compact('grupos', 'empresas', 'id_empresa'));
            //} else {
            //    return redirect('/grupo/create');
            //}
        } else {
            return redirect('/empresa/create');
        }

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
        $grupo = new Grupo;
        $empresas = Empresa::all();
        $usuarios = Usuario::all();

        return view('grupo.edit', compact('grupo', 'empresas', 'usuarios'));
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

        $grupo = new Grupo();
        $grupo->nome = $request->nome;
        $grupo->emp_id = $request->emp_id;
        $grupo->save();

        return redirect()->action('GrupoController@index', ['id_empresa'=> $request->emp_id]);
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
        $grupo = Grupo::findOrFail($id);
        $empresas = Empresa::all();
        $usuarios = Usuario::all();


        return view('grupo.edit', compact('grupo', 'empresas', 'usuarios'));
    }

    private function validar(Request $request) {
        $this->validate($request, [
            'nome' => 'required',
            'emp_id' => 'required'
        ],
            [
                'nome.required' => 'O nome do grupo é obrigatório',
                'emp_id.required' => 'A Empresa é obrigatoria'
            ]);
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

        $grupo = Grupo::find($id);
        $grupo->nome = $request->nome;
        $grupo->emp_id = $request->emp_id;

        $grupo->save();

        //atualizando usuarios do grupo
        if ($request['usuarios']) {
            $grupo->usuarios()->sync($request['usuarios']);

        } else {
            $grupo->usuarios()->sync([]);
        }

        return redirect()->action('GrupoController@index', ['id_empresa'=> $request->emp_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grupo_deleted = Grupo::findOrFail($id);

        $grupo_deleted ->delete();

        session()->flash('grupo_deleted', $grupo_deleted);

        return redirect()->action('GrupoController@index', ['id_empresa'=> $grupo_deleted->emp_id]);

    }

    public function restore($id)
    {

        Grupo::onlyTrashed()->where('id','=',$id)->firstOrFail()->restore();

        return redirect()->action('GrupoController@index');

    }

}
