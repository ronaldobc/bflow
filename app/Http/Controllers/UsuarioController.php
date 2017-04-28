<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{


    public function __construct() {
        $this->middleware('auth');
    }

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

        //upload da foto
        if ($foto = $request->file('foto')) {
            $nome_arq = str_replace('.','_',str_replace('@','',$usuario->email)) . '.' . $foto->extension();
            $foto->move($usuario->diretorio_foto, $nome_arq);
            $usuario->foto = $nome_arq;
        }

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
            ],
                [
                    'nome.required' => 'O nome do Usuário é obrigatório',
                    'email.required' => 'O E-mail é obrigatório',
                    'password.required' => 'A senha é obrigatória',
                    'password.confirmed' => 'A senha não combina com a confirmação'
                ]);
        } else {
            $this->validate($request, [
                'nome' => 'required',
                'email' => 'required|email',
            ],
                [
                    'nome.required' => 'O nome do Usuário é obrigatório',
                    'email.required' => 'O E-mail é obrigatório',
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

        //upload da foto
        if ($foto = $request->file('foto')) {
            $nome_arq = str_replace('.','_',str_replace('@','',$usuario->email)) . '.' . $foto->extension();

            if ($usuario->foto != '' && $usuario->foto != $nome_arq) {
                if (file_exists(public_path() . '\\' . $usuario->fotoPath)) {
                    unlink(public_path() . '\\' . $usuario->fotoPath);
                }
            }

            $foto->move($usuario->diretorio_foto, $nome_arq);
            $usuario->foto = $nome_arq;
        }

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
