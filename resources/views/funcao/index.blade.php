@extends('app.template')

@section('titulo_pagina', 'Funções')
@section('cabecalho_pagina', 'Funções')
@section('descricao_pagina', 'Lista as funções de colaboradores cadastrados')

@section('content')

        <div class="box box-primary">

            <div class="box-body">

                @if (session()->has('funcao_deleted'))
                    <div class="callout callout-success">
                        A função "{{session('funcao_deleted')->nome}}" foi excluida com sucesso.
                    </div>
                @endif

                <label for="empresa">Empresa</label>
                <select size="1" name="empresa" id="empresa" class="form-control" onchange="atualizar();">
                @foreach($empresas as $empresa)
                        <option value="{{$empresa->id}}" {{($empresa->id==$id_empresa)?('selected="selected"'):('')}}>{{$empresa->nome}}</option>
                @endforeach
                </select>

                @if (empty($funcoes))
                    @else
                <table id="listagem" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Empresa</th>
                        <th>Criado em</th>
                        <th>Alterado em</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($funcoes as $funcao)
                    <tr>
                        <td>{{$funcao->id}}</td>
                        <td><a href="/funcao/{{$funcao->id}}/edit">{{$funcao->nome}}</a></td>
                        <td>{{$funcao->empresa->nome}}</td>
                        <td>{{$funcao->created_at->diffForHumans()}}</td>
                        <td>{{$funcao->updated_at->diffForHumans()}}</td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif

            </div>


            <div class="box-footer">
                <a href="{{route('funcao.create')}}" class="btn btn-primary">Nova Função</a>
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
        document.location = "/funcao/empresa/" + $('#empresa').val();
    }
    </script>
@endsection
