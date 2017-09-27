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
                        <!--<th>#</th>-->
                        <th>Avatar</th>
                        <th>Nome</th>
                        <th>Ativo</th>
                        <th>Departamentos</th>
                        <th>Funções</th>
                        <th>Grupos</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($usuarios as $usuario)
                    <tr>
                        <!--<td>{{$usuario->id}}</td>-->
                        <td><a href="/usuario/{{$usuario->id}}/edit"><img src="{{$usuario->fotoPath}}" width="70px" class="img-responsive img-thumbnail"></a></td>
                        <td><a href="/usuario/{{$usuario->id}}/edit">{{$usuario->nome}}</a><br/>
                            <a href="/usuario/{{$usuario->id}}/edit">{{$usuario->email}}</a>
                        </td>
                        <td>{{($usuario->ativo)?('Sim'):('Não')}}</td>
                        <td>
                            @if ($usuario->departamentosAtuais()->count() >0)
                                @foreach($usuario->departamentosAtuais() as $depto)
                                    <a href="{{route('alocacao.usuario.empresa.show',[$usuario->id,$depto->departamento->empresa->id,'dep'])}}">
                                        {{$depto->departamento->nome}}<br/>
                                        <span class="label label-success">{{$depto->nivel->nome}}</span>
                                        <span class="label label-primary">{{$depto->departamento->empresa->nome}}</span><br/>
                                    </a>
                                @endforeach
                            @else
                                <a href="{{route('alocacao.usuario.show',[$usuario->id,'dep'])}}">Alocar</a>
                            @endif
                        </td>
                        <td>
                            @if ($usuario->funcoesAtuais()->count() >0)
                                @foreach($usuario->funcoesAtuais() as $func)
                                    <a href="{{route('alocacao.usuario.empresa.show',[$usuario->id,$depto->departamento->empresa->id,'func'])}}">
                                        {{$func->funcao->nome}}<br/>
                                        <span class="label label-primary">{{$func->funcao->empresa->nome}}</span><br/>
                                    </a>
                                @endforeach
                            @else
                                <a href="{{route('alocacao.usuario.show',[$usuario->id,'func'])}}">Alocar</a>
                            @endif
                        </td>
                        <td>
                            @foreach($usuario->grupos as $grupo)
                                {{$grupo->nome}}&nbsp;
                                <span class="label label-primary">{{$grupo->empresa->nome}}</span><br/>
                            @endforeach
                        </td>
                        <td><small>Criado {{$usuario->created_at->diffForHumans()}}<br/>
                            Alterado {{$usuario->updated_at->diffForHumans()}}</small></td>
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

@section('scripts')

    <script type="text/javascript">
        $(function () {
            $('#listagem').DataTable({
                'paging'      : false,
                'lengthChange': false,
                'searching'   : true,
                'ordering'    : false,
                'info'        : false,
                'autoWidth'   : true
            });
        })

    </script>

@endsection
