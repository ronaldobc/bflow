@extends('app.template')

@section('titulo_pagina', 'Departamentos')

@section('content')

        <div class="box box-primary">

        @if ($depto->id <= 0)

            @section('cabecalho_pagina', 'Criar Departamento')
            @section('descricao_pagina', 'Cria um novo departamento')

            {!! Form::open(['route' => 'departamento.store', 'id' => 'frm_editar']) !!}

        @else

            @section('cabecalho_pagina', 'Alterar Departamento')
            @section('descricao_pagina', 'Altera o departamento selecionada')


            {!! Form::open(['route' => ['departamento.update', $depto->id], 'method' => 'put', 'id' => 'frm_editar']) !!}


        @endif

                    <div class="box-body">

                            <div class="form-group">
                                <label>Nome</label>
                                {!! Form::text('nome', $depto->nome, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                <label>Empresa</label>
                                @if ($depto->empresa)
                                    {!! Form::hidden('emp_id', $depto->emp_id) !!}
                                    <br/><span id="empresa">{{$depto->empresa->nome}}</span>
                                @else
                                    {!! Form::select('emp_id', $empresas->pluck('nome','id'), $depto->emp_id, ['placeholder'=>'Selecione uma empresa','class'=>'form-control']) !!}
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Pertence ao Departamento</label>
                                @if ($depto->id <= 0)
                                    {!! Form::select('dep_cd_pai', [], null, ['placeholder'=>'Departamento raiz','class'=>'form-control']) !!}
                                @else
                                    {!! Form::hidden('dep_cd_pai', $depto->dep_cd_pai) !!}
                                    @if ($depto->departamentoPai)
                                        <br/><span id="depto_pai">{{$depto->departamentoPai->nome}}</span>
                                    @else
                                        <br/><span id="depto_pai">Departamento Raiz</span>
                                    @endif
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
                @if ($depto->id > 0)
                    <button type="button" class="btn btn-danger" onclick="excluir();">Excluir</button>
                    {!! Form::open(['route' => ['departamento.destroy', $depto->id], 'method' => 'delete', 'id' => 'frm_excluir']) !!}
                    {!! Form::close() !!}
                @endif
            </div>


        </div>



@endsection

@section('scripts')

    <script type="text/javascript">
        function excluir() {
            if (confirm('Confirma a exclusão do departamento?')) {
                $('#frm_excluir').submit();
            }
        }

        $('[name=emp_id]').on('change', function(){
            //alert($(this).val());
            $.ajax({
                method: "GET",
                url: "/departamento/empresa/"+$(this).val(),
                data: {}
            })
                .done(function( msg ) {
                    opcoes = '<option value="">Departamento raiz</option>';
                    for(x=0; x<msg.length; x++) {
                        opcoes += '<option value="'+msg[x].id+'">'+msg[x].nome+'</option>';
                    }
                    $('[name="dep_cd_pai"]').html(opcoes);
            });
        });
    </script>

@endsection
