<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;

class EmpresaController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    protected function inicio($empresa_deleted = null)
    {

        $empresas = Empresa::all();

        if ($empresas->count() > 0) {
            //return view('empresa.index', compact('empresas','empresa_deleted'));
            return view('empresa.index', compact('empresas'));
        } else {
            //return redirect()->route('empresa.create');
            return redirect('/empresa/create');
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($empresa_deleted = null)
    {

        return $this->inicio($empresa_deleted);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $empresa = new Empresa;

        return view('empresa.edit', compact('empresa'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validar($request);

        $empresa = new Empresa();
        $empresa->nome = $request->nome;
        $empresa->save();

        return redirect()->action('EmpresaController@index');

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
        $empresa = Empresa::findOrFail($id);

        return view('empresa.edit', compact('empresa'));
    }

    private function validar(Request $request) {
        $this->validate($request, [
            'nome' => 'required'
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

        $empresa = Empresa::find($id);
        $empresa->nome = $request->nome;
        $empresa->save();

        return redirect()->action('EmpresaController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empresa_deleted = Empresa::findOrFail($id);

        $empresa_deleted ->delete();

        session()->flash('empresa_deleted', $empresa_deleted);

        return redirect()->action('EmpresaController@index');
        //return $this->inicio($empresa_deleted);

    }

    public function restore($id)
    {

        Empresa::onlyTrashed()->where('id','=',$id)->firstOrFail()->restore();

        return redirect()->action('EmpresaController@index');

    }

}
