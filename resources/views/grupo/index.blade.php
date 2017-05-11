@extends('app.template')

@section('titulo_pagina', 'Grupos de Usuários')
@section('cabecalho_pagina', 'Grupos de usuários')
@section('descricao_pagina', 'Lista os grupos de usuários cadastrados')

@section('content')

        <div class="box box-primary">

            <div class="box-body">

                @if (session()->has('grupo_deleted'))
                    <div class="callout callout-success">
                        O grupo "{{session('grupo_deleted')->nome}}" foi excluido com sucesso.
                    </div>
                @endif

                <label for="empresa">Empresa</label>
                <select size="1" name="empresa" id="empresa" class="form-control" onchange="atualizar();">
                @foreach($empresas as $empresa)
                        <option value="{{$empresa->id}}" {{($empresa->id==$id_empresa)?('selected="selected"'):('')}}>{{$empresa->nome}}</option>
                @endforeach
                </select>

                @if (empty($grupos))
                    @else
                <table id="listagem" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Usuários</th>
                        <th>Empresa</th>
                        <th>Criado em</th>
                        <th>Alterado em</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($grupos as $grupo)
                    <tr>
                        <td>{{$grupo->id}}</td>
                        <td><a href="/grupo/{{$grupo->id}}/edit">{{$grupo->nome}}</a></td>
                        <td>{{$grupo->usuarios->count()}}</td>
                        <td>{{$grupo->empresa->nome}}</td>
                        <td>{{$grupo->created_at->diffForHumans()}}</td>
                        <td>{{$grupo->updated_at->diffForHumans()}}</td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif

            </div>


            <div class="box-footer">
                <a href="{{route('grupo.create')}}" class="btn btn-primary">Novo Grupo</a>
            </div>

            @if($errors->getMessages())
                <div class="callout callout-danger">
                    @foreach($errors->getMessages() as $error)
                        {{ $error[0] }}<br/>
                    @endforeach
                </div>
            @endif

        </div>

@endsection

@section('scripts')
    <script type="text/javascript">
    function atualizar()
    {
        document.location = "/grupo/empresa/" + $('#empresa').val();
    }
    </script>
@endsection
