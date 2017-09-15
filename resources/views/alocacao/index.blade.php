@extends('app.template')

@section('titulo_pagina', 'Alocação de Usuários')
@section('cabecalho_pagina', 'Alocação de Usuários')
@section('descricao_pagina', 'Exibe as alocações de um usuário')

@section('content')

        <div class="box box-primary">

            <div class="box-body">

                <h4>{{$usuario->nome}}</h4>

                <label for="empresa">Empresa</label>
                <select size="1" name="empresa" id="empresa" class="form-control" onchange="atualizar();">
                @foreach($empresas as $empresa)
                        <option value="{{$empresa->id}}" {{($empresa->id==$id_empresa)?('selected="selected"'):('')}}>{{$empresa->nome}}</option>
                @endforeach
                </select>

                <br/>

                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li {{($aba=='dep')?('class=active'):('')}}><a href="#tab_1" data-toggle="tab">Departamento</a></li>
                        <li {{($aba=='func')?('class=active'):('')}}><a href="#tab_2" data-toggle="tab">Função</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane {{($aba=='dep')?('active'):('')}}" id="tab_1">

                            {!! Form::open(['route' => ['alocacao.usuario.storedep',$usuario->id], 'id' => 'frm_editar']) !!}
                            {!! Form::hidden('emp_id', $id_empresa) !!}

                                <div class="row callout callout-info">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Novo Departamento</label>
                                            {!! Form::select('dep_id', $departamentos->pluck('nome','id'), null, ['placeholder'=>'Selecione um departamento','class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Nova Hierarquia</label>
                                            {!! Form::select('nivel_id', $niveis->pluck('nome','id'), null, ['placeholder'=>'Selecione uma hierarquia','class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="checkbox icheck">
                                            <label>
                                                {!! Form::checkbox('finaliza_outras', '1') !!}&nbsp;&nbsp;&nbsp;Finalizar as alocações em outras empresas
                                            </label>
                                        </div>
                                        <div class="checkbox icheck">
                                            <label>
                                                {!! Form::checkbox('finaliza_atual', '1','1') !!}&nbsp;&nbsp;&nbsp;Finalizar as alocações nesta empresa
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-primary" onclick="$('#frm_editar').submit();" >Alocar</button>
                                    </div>
                                </div>

                            {!! Form::close() !!}

                            @if($errors->getMessages())
                                <div class="callout callout-danger">
                                    @foreach($errors->getMessages() as $error)
                                        {{ $error[0] }}<br/>
                                    @endforeach
                                </div>
                            @endif

                            <p><b>Histórico de Departamentos:</b></p>

                            @if (empty($usuario_dep))
                            @else
                                <table id="listagem" class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>Departamento</th>
                                        <th>Hierarquia</th>
                                        <th>Inicio</th>
                                        <th>Fim</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($usuario_dep as $user_dep)
                                        <tr>
                                            <td>{{$user_dep->departamento->nome}}</td>
                                            <td>{{$user_dep->nivel->nome}}</td>
                                            <td>{{$user_dep->inicio->format('d/m/Y') . ' ('. $user_dep->inicio->diffForHumans() .')'}}</td>
                                            @if($user_dep->fim)
                                                <td>{{$user_dep->fim->format('d/m/Y'). ' ('. $user_dep->fim->diffForHumans() .')'}}</td>
                                                <td>&nbsp;</td>
                                            @else
                                                <td>Atual</td>
                                                <td>
                                                    <a href="#" onclick="confirmaFinaliza('dep',{{$user_dep->id}})" class="btn btn-danger btn-sm">Finalizar</a>
                                                </td>
                                            @endif

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane {{($aba=='func')?('active'):('')}}" id="tab_2">

                            {!! Form::open(['route' => ['alocacao.usuario.storefunc',$usuario->id], 'id' => 'frm_editar_func']) !!}
                            {!! Form::hidden('emp_id', $id_empresa) !!}

                            <div class="row callout callout-info">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nova Função</label>
                                        {!! Form::select('func_id', $funcoes->pluck('nome','id'), null, ['placeholder'=>'Selecione uma função','class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="checkbox icheck">
                                        <label>
                                            {!! Form::checkbox('finaliza_outras_func', '1') !!}&nbsp;&nbsp;&nbsp;Finalizar as funções em outras empresas
                                        </label>
                                    </div>
                                    <div class="checkbox icheck">
                                        <label>
                                            {!! Form::checkbox('finaliza_atual_func', '1','1') !!}&nbsp;&nbsp;&nbsp;Finalizar as funções nesta empresa
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-primary" onclick="$('#frm_editar_func').submit();" >Alocar</button>
                                </div>
                            </div>

                            {!! Form::close() !!}

                            @if($errors->getMessages())
                                <div class="callout callout-danger">
                                    @foreach($errors->getMessages() as $error)
                                        {{ $error[0] }}<br/>
                                    @endforeach
                                </div>
                            @endif

                            <p><b>Histórico de Funções:</b></p>

                            @if (empty($usuario_dep))
                            @else
                                <table id="listagem" class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>Função</th>
                                        <th>Inicio</th>
                                        <th>Fim</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($usuario_func as $user_func)
                                        <tr>
                                            <td>{{$user_func->funcao->nome}}</td>
                                            <td>{{$user_func->inicio->format('d/m/Y') . ' ('. $user_func->inicio->diffForHumans() .')'}}</td>
                                            @if($user_func->fim)
                                                <td>{{$user_func->fim->format('d/m/Y'). ' ('. $user_func->fim->diffForHumans() .')'}}</td>
                                                <td>&nbsp;</td>
                                            @else
                                                <td>Atual</td>
                                                <td>
                                                    <a href="#" onclick="confirmaFinaliza('func',{{$user_func->id}})" class="btn btn-danger btn-sm">Finalizar</a>
                                                </td>
                                            @endif

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- nav-tabs-custom -->

            </div>

        </div>

@endsection

@section('scripts')
    <script src="{{ asset("/admin-lte/plugins/iCheck/icheck.min.js")}}"></script>
    <script type="text/javascript">
    function atualizar()
    {
        document.location = "/alocacao/usuario/{{$usuario->id}}/empresa/" + $('#empresa').val();
    }
    function confirmaFinaliza(tipo, id) {
        if (confirm("Confirma a finalização da alocação?")) {
            if (tipo === "dep") {
                document.location = '/alocacaodep/'+id+'/finaliza';
            } else {
                document.location = '/alocacaofunc/'+id+'/finaliza';
            }
        }
    }
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
    </script>
@endsection
