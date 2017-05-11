@extends('app.template')

@section('titulo_pagina', 'Grupos de Usuário')

@section('content')

        <div class="box box-primary">

        @if ($grupo->id <= 0)

            @section('cabecalho_pagina', 'Criar Grupo')
            @section('descricao_pagina', 'Cria um novo grupo de usuários')

            {!! Form::open(['route' => 'grupo.store', 'id' => 'frm_editar']) !!}

        @else

            @section('cabecalho_pagina', 'Alterar Grupo')
            @section('descricao_pagina', 'Altera o grupo de usuário selecionado')


            {!! Form::open(['route' => ['grupo.update', $grupo->id], 'method' => 'put', 'id' => 'frm_editar']) !!}


        @endif

                    <div class="box-body">

                            <div class="form-group">
                                <label>Nome</label>
                                {!! Form::text('nome', $grupo->nome, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                <label>Empresa</label>
                                @if ($grupo->empresa)
                                    {!! Form::hidden('emp_id', $grupo->emp_id) !!}
                                    <br/><span id="empresa">{{$grupo->empresa->nome}}</span>
                                @else
                                    {!! Form::select('emp_id', $empresas->pluck('nome','id'), $grupo->emp_id, ['placeholder'=>'Selecione uma empresa','class'=>'form-control']) !!}
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Usuários</label>
                                {!! Form::select('usuarios[]', $usuarios->pluck('nome', 'id'), $grupo->usuarios->pluck('id'),['id'=>'usuarios','class'=>'form-control select2']) !!}
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
                @if ($grupo->id > 0)
                    <button type="button" class="btn btn-danger" onclick="excluir();">Excluir</button>
                    {!! Form::open(['route' => ['grupo.destroy', $grupo->id], 'method' => 'delete', 'id' => 'frm_excluir']) !!}
                    {!! Form::close() !!}
                @endif

            </div>


        </div>



@endsection

@section('scripts')

    <script type="text/javascript">
        function excluir() {
            if (confirm('Confirma a exclusão do grupo de usuário?')) {
                $('#frm_excluir').submit();
            }
        }

        $(".select2").select2({multiple: true});
        $(".select2").val({{$grupo->usuarios->pluck('id')}}).trigger("change");
    </script>

@endsection
