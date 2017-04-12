@extends('app.template')

@section('titulo_pagina', 'Usuários')
@section('cabecalho_pagina', 'Usuários')
@section('descricao_pagina', 'Lista os usuários cadastrados')

@section('content')

        <div class="box box-primary">

            <div class="box-body">

                @if (session()->has('usuario_deleted'))
                    {!! Form::open(['route' => ['usuario.restore', session('usuario_deleted')->id], 'id' => 'frm_restore']) !!}
                    {!! Form::close() !!}
                    <div class="callout callout-success">
                        O usuário "{{session('usuario_deleted')->nome}}" foi excluido com sucesso.&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="#" onclick="$('#frm_restore').submit()">Restaurar</a>
                    </div>
                @endif

                @if (empty($usuarios))
                    @else
                <table id="listagem" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>&nbsp;</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Ativo</th>
                        <th>Criado em</th>
                        <th>Alterado em</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{$usuario->id}}</td>
                        <td><img src="{{$usuario->fotoPath}}" width="70px" class="img-responsive img-thumbnail"></td>
                        <td><a href="/usuario/{{$usuario->id}}/edit">{{$usuario->nome}}</a></td>
                        <td><a href="/usuario/{{$usuario->id}}/edit">{{$usuario->email}}</a></td>
                        <td>{{($usuario->ativo)?('Sim'):('Não')}}</td>
                        <td>{{$usuario->created_at->diffForHumans()}}</td>
                        <td>{{$usuario->updated_at->diffForHumans()}}</td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif

            </div>

            <div class="box-footer">
                <a href="{{route('usuario.create')}}" class="btn btn-primary">Novo Usuário</a>
            </div>

        </div>

@endsection
