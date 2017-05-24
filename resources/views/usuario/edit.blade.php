@extends('app.template')

@section('titulo_pagina', 'Usuários')

@section('content')
        <div class="box box-primary">

        @if ($usuario->id <= 0)

            @section('cabecalho_pagina', 'Criar Usuário')
            @section('descricao_pagina', 'Cria novo usuário')

            {!! Form::open(['route' => 'usuario.store', 'id' => 'frm_editar', 'files' => true]) !!}

        @else

            @section('cabecalho_pagina', 'Alterar Usuário')
            @section('descricao_pagina', 'Altera o usuário selecionado')


            {!! Form::open(['route' => ['usuario.update', $usuario->id], 'files' => true, 'method' => 'put', 'id' => 'frm_editar']) !!}


        @endif

                    <div class="box-body">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            {!! Form::text('nome', $usuario->nome, ['class'=>'form-control']) !!}
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            {!! Form::text('email', $usuario->email, ['class'=>'form-control']) !!}
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="password">Senha</label>
                                    {!! Form::password('password', ['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmação de  Senha</label>
                                    {!! Form::password('password_confirmation', ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Foto</label>
                                    {!! Form::file('foto', ['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-6">
                                @if ($usuario->foto != '')
                                    <img src="{{$usuario->fotoPath}}" width="100px" class="img-responsive img-thumbnail" />
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Grupos</label>
                            {!! Form::select('grupos[]', $grupos->pluck('nome', 'id'), null,['id'=>'grupos','class'=>'form-control select2']) !!}
                        </div>

                        <div class="checkbox icheck">
                            <label>
                                {!! Form::checkbox('ativo', '1', ($usuario->ativo == 1)) !!}&nbsp;&nbsp;&nbsp;Ativo?
                            </label>
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
                @if ($usuario->id > 0)
                    <button type="button" class="btn btn-danger" onclick="excluir();">Excluir</button>
                    {!! Form::open(['route' => ['usuario.destroy', $usuario->id], 'method' => 'delete', 'id' => 'frm_excluir']) !!}
                    {!! Form::close() !!}
                @endif
            </div>


        </div>



@endsection

@section('scripts')

    <script type="text/javascript">
        function excluir() {
            if (confirm('Confirma a exclusão do usuário?')) {
                $('#frm_excluir').submit();
            }
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

            $("#grupos").select2({multiple: true});
            $("#grupos").val({{$usuario->grupos->pluck('id')}}).trigger("change");

        });
    </script>

@endsection
