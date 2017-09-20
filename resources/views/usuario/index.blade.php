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

                    <div class="box-header">
                        <a href="{{route('usuario.create')}}" class="btn btn-primary">Novo Usuário</a>
                    </div>

                @if (empty($usuarios))
                    @else
                <table id="listagem" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Avatar</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Ativo</th>
                        <th>Departamentos</th>
                        <th>Funções</th>
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
                        <td>
                            @if ($usuario->departamentosAtuais()->count() >0)
                                @foreach($usuario->departamentosAtuais() as $depto)
                                    <a href="{{route('alocacao.usuario.empresa.show',[$usuario->id,$depto->departamento->empresa->id,'aba=dep'])}}">
                                        {{$depto->departamento->nome}}<br/>
                                        <span class="label label-success">{{$depto->nivel->nome}}</span>
                                        <span class="label label-primary">{{$depto->departamento->empresa->nome}}</span><br/>
                                    </a>
                                @endforeach
                            @else
                                <a href="{{route('alocacao.usuario.show',[$usuario->id,'aba=dep'])}}">Alocar</a>
                            @endif
                        </td>
                        <td>
                            @if ($usuario->funcoesAtuais()->count() >0)
                                @foreach($usuario->funcoesAtuais() as $func)
                                    <a href="{{route('alocacao.usuario.empresa.show',[$usuario->id,$depto->departamento->empresa->id,'aba=func'])}}">
                                        {{$func->funcao->nome}}<br/>
                                        <span class="label label-primary">{{$func->funcao->empresa->nome}}</span>
                                    </a>
                                @endforeach
                            @else
                                <a href="{{route('alocacao.usuario.show',[$usuario->id,'aba=func'])}}">Alocar</a>
                            @endif
                        </td>
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
