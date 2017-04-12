@extends('app.template')

@section('titulo_pagina', 'Empresas')
@section('cabecalho_pagina', 'Empresas')
@section('descricao_pagina', 'Lista as empresas cadastradas')

@section('content')

        <div class="box box-primary">

            <div class="box-body">

                @if (session()->has('empresa_deleted'))
                    {!! Form::open(['route' => ['empresa.restore', session('empresa_deleted')->id], 'id' => 'frm_restore']) !!}
                    {!! Form::close() !!}
                    <div class="callout callout-success">
                        A empresa "{{session('empresa_deleted')->nome}}" foi excluida com sucesso.&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="#" onclick="$('#frm_restore').submit()">Restaurar</a>
                    </div>
                @endif

                @if (empty($empresas))
                    @else
                <table id="listagem" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Criado em</th>
                        <th>Alterado em</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($empresas as $empresa)
                    <tr>
                        <td>{{$empresa->id}}</td>
                        <td><a href="/empresa/{{$empresa->id}}/edit">{{$empresa->nome}}</a></td>
                        <td>{{$empresa->created_at->diffForHumans()}}</td>
                        <td>{{$empresa->updated_at->diffForHumans()}}</td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif

            </div>

            <div class="box-footer">
                <a href="{{route('empresa.create')}}" class="btn btn-primary">Nova Empresa</a>
            </div>

        </div>

@endsection
