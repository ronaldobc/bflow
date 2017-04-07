@extends('app.template')

@section('titulo_pagina', 'Empresas')

@section('content')
        <div class="box box-primary">

        @if ($empresa->id <= 0)

            @section('cabecalho_pagina', 'Criar Empresa')
            @section('descricao_pagina', 'Cria nova empresa')
            <!--<form action="{{route('empresa.store')}}" method="POST" role="form">-->
            {!! Form::open(['route' => 'empresa.store', 'id' => 'frm_editar']) !!}

        @else

            @section('cabecalho_pagina', 'Alterar Empresa')
            @section('descricao_pagina', 'Altera a empresa selecionada')
            <!--<form action="{{route('empresa.update',['id'=>$empresa->id])}}" method="POST" role="form" id="frm_editar">-->
            <!--<input type="hidden" name="_method" value="PUT">-->

            {!! Form::open(['route' => ['empresa.update', $empresa->id], 'method' => 'put', 'id' => 'frm_editar']) !!}


        @endif

                    <div class="box-body">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Nome</label>
                                <!--<input type="text" class="form-control" name="nome" value="{{empty($empresa)?(''):($empresa->nome)}}">-->
                                {!! Form::text('nome', $empresa->nome, ['class'=>'form-control']) !!}
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
                @if ($empresa->id > 0)
                    <button type="button" class="btn btn-danger" onclick="excluir();">Excluir</button>
                    {!! Form::open(['route' => ['empresa.destroy', $empresa->id], 'method' => 'delete', 'id' => 'frm_excluir']) !!}
                    {!! Form::close() !!}
                @endif
            </div>


        </div>



@endsection

@section('scripts')

    <script type="text/javascript">
        function excluir() {
            if (confirm('Confirma a exclusão da empresa?')) {
                $('#frm_excluir').submit();
            }
        }
    </script>

@endsection
