<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = Usuario::all();

        if ($usuarios->count() > 0) {
            return view('usuario.index', compact('usuarios'));
        } else {
            return redirect('/usuario/create');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuario = new Usuario;

        return view('usuario.edit', compact('usuario'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validar($request, true);

        $usuario = new Usuario();
        $usuario->nome = $request->nome;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->ativo = (!$request->ativo)?(0):(1);
        $usuario->save();

        return redirect()->action('UsuarioController@index');
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
        $usuario = Usuario::findOrFail($id);

        return view('usuario.edit', compact('usuario'));
    }

    private function validar(Request $request, $novo) {
        if ($novo || $request['password'] != '') {
            $this->validate($request, [
                'nome' => 'required',
                'email' => 'required|email',
                'password' => 'required|confirmed'
            ]);
        } else {
            $this->validate($request, [
                'nome' => 'required',
                'email' => 'required|email',
            ]);
        }
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
        $this->validar($request, false);

        $usuario = Usuario::find($id);
        $usuario->nome = $request->nome;
        $usuario->email = $request->email;
        if ($request['password'] != '') {
            $usuario->password = bcrypt($request->password);
        }
        $usuario->ativo = (!$request->ativo)?(0):(1);

        $usuario->save();

        return redirect()->action('UsuarioController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario_deleted = Usuario::findOrFail($id);

        $usuario_deleted->delete();

        session()->flash('usuario_deleted', $usuario_deleted);

        return redirect()->action('UsuarioController@index');
    }


    public function restore($id)
    {

        Usuario::onlyTrashed()->where('id','=',$id)->firstOrFail()->restore();

        return redirect()->action('UsuarioController@index');

    }

}
