@extends('app.template')

@section('titulo_pagina', 'Permissão por Função')
@section('cabecalho_pagina', 'Permissão por Função')
@section('descricao_pagina', 'Define as permissões de acesso por funções de colaboradores')

@section('content')

        <div class="box box-primary">

            {!! Form::open(['route' => ['permissaofuncao.update', $funcao->id], 'method' => 'put', 'id' => 'frm_editar']) !!}

            <div class="box-body">

                <label for="funcao">Funções</label>
                <select size="1" name="funcao" id="funcao" class="form-control" onchange="atualizar()">
                @foreach($funcoes as $funcaoc)
                        <option value="{{$funcaoc->id}}" {{($funcaoc->id==$id_funcao)?('selected="selected"'):('')}}>{{$funcaoc->nome.' [' . $funcaoc->empresa->nome.']'}}</option>
                @endforeach
                </select>

                <table id="listagem" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th colspan="2">Permissão</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($modulos as $modulo)
                    <tr>
                        <td colspan="2">
                            <label>
                                {!! Form::checkbox('perm_modulo[]', $modulo->id, ($funcao->modulos->contains($modulo->id))) !!}
                                {{$modulo->descricao}}
                            </label>
                        </td>
                    </tr>
                        @foreach($modulo->acoes as $acao)
                            <tr>
                                <td width="10px">&nbsp;</td>
                                <td>
                                    <label>
                                        {!! Form::checkbox('perm_acao[]', $acao->id, ($funcao->acoes->contains($acao->id))) !!}
                                        {{$acao->descricao}}
                                    </label>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>

            </div>


            <div class="box-footer">
                <input type="submit" value="Salvar" class="btn btn-primary" />
            </div>

            {!! Form::close() !!}

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
        document.location = "/permissao/funcao/" + $('#funcao').val();
    }
    </script>

    <script src="{{ asset("/admin-lte/plugins/iCheck/icheck.min.js")}}"></script>
    <script type="text/javascript">
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>

@endsection
