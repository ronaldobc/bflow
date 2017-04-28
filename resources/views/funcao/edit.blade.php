@extends('app.template')

@section('titulo_pagina', 'Funções')

@section('content')

        <div class="box box-primary">

        @if ($funcao->id <= 0)

            @section('cabecalho_pagina', 'Criar Função')
            @section('descricao_pagina', 'Cria um nova função')

            {!! Form::open(['route' => 'funcao.store', 'id' => 'frm_editar']) !!}

        @else

            @section('cabecalho_pagina', 'Alterar Função')
            @section('descricao_pagina', 'Altera a função selecionada')


            {!! Form::open(['route' => ['funcao.update', $funcao->id], 'method' => 'put', 'id' => 'frm_editar']) !!}


        @endif

                    <div class="box-body">

                            <div class="form-group">
                                <label>Nome</label>
                                {!! Form::text('nome', $funcao->nome, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                <label>Empresa</label>
                                @if ($funcao->empresa)
                                    {!! Form::hidden('emp_id', $funcao->emp_id) !!}
                                    <br/><span id="empresa">{{$funcao->empresa->nome}}</span>
                                @else
                                    {!! Form::select('emp_id', $empresas->pluck('nome','id'), $funcao->emp_id, ['placeholder'=>'Selecione uma empresa','class'=>'form-control']) !!}
                                @endif
                            </div>

                        @if($errors->getMessages())
                            <div class="callout callout-danger">
                                @foreach($errors->getMessages() as $error)
                                    {{ $error[0] }}<br/>
                                @endforeach
                            </div>
                        @endif

                    </div>

            {!! Form::close() !!}


            <div class="box-footer">
                <button type="button" class="btn btn-primary" onclick="$('#frm_editar').submit();" >Gravar</button>
                @if ($funcao->id > 0)
                    <button type="button" class="btn btn-danger" onclick="excluir();">Excluir</button>
                    {!! Form::open(['route' => ['funcao.destroy', $funcao->id], 'method' => 'delete', 'id' => 'frm_excluir']) !!}
                    {!! Form::close() !!}
                @endif
            </div>


        </div>



@endsection

@section('scripts')

    <script type="text/javascript">
        function excluir() {
            if (confirm('Confirma a exclusão da função?')) {
                $('#frm_excluir').submit();
            }
        }
    </script>

@endsection
