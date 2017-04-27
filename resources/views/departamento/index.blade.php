@extends('app.template')

@section('titulo_pagina', 'Departamentos')
@section('cabecalho_pagina', 'Departamentos')
@section('descricao_pagina', 'Lista os departamentos cadastrados')

@section('content')

        <div class="box box-primary">

            <div class="box-body">

                @if (session()->has('depto_deleted'))
                    <div class="callout callout-success">
                        O departamento "{{session('depto_deleted')->nome}}" foi excluido com sucesso.
                    </div>
                @endif

                <label for="empresa">Empresa</label>
                <select size="1" name="empresa" id="empresa" class="form-control" onchange="atualizar();">
                @foreach($empresas as $empresa)
                        <option value="{{$empresa->id}}" {{($empresa->id==$id_empresa)?('selected="selected"'):('')}}>{{$empresa->nome}}</option>
                @endforeach
                </select>

{{--                @if (empty($departamentos))
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
                    @foreach($departamentos as $depto)
                    <tr>
                        <td>{{$depto->id}}</td>
                        <td><a href="/departamento/{{$depto->id}}/edit">{{$depto->nome}}</a></td>
                        <td>{{$depto->empresa->nome}}</td>
                        <td>{{$depto->created_at->diffForHumans()}}</td>
                        <td>{{$depto->updated_at->diffForHumans()}}</td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif--}}

                    <table id="tabela" class="table table-responsive table-condensed table-hover table-striped fancytree-fade-expander">
                        <colgroup>
                            <col width="10px"></col>
                            <col width="30px"></col>
                            <col width="*"></col>
                        </colgroup>                        <thead>
                        <tr> <th></th> <th></th><th>Departamentos</th>  </tr>
                        </thead>
                        <tbody>
                        <tr> <td></td> <td></td> <td></td> </tr>
                        </tbody>
                    </table>
            </div>


            <div class="box-footer">
                <a href="{{route('departamento.create')}}" class="btn btn-primary">Novo Departamento</a>
            </div>

            {!! Form::open(['route' => ['departamento.update', 0], 'method' => 'put', 'id' => 'frm_editar']) !!}
            {!! Form::hidden('dep_cd_pai',0) !!}
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
            //document.location = '/departamento/empresa/' + $('#empresa').val();
            $('#tabela').fancytree('getTree').reload({url: "/departamento_tree/" + $('#empresa').val()});
        }

        glyph_opts = {
            map: {
                doc: "fa fa-cube",
                docOpen: "fa fa-cube",
                checkbox: "glyphicon glyphicon-unchecked",
                checkboxSelected: "glyphicon glyphicon-check",
                checkboxUnknown: "glyphicon glyphicon-share",
                dragHelper: "glyphicon glyphicon-play",
                dropMarker: "glyphicon glyphicon-arrow-right",
                error: "glyphicon glyphicon-warning-sign",
                expanderClosed: "glyphicon glyphicon-menu-right",
                expanderLazy: "glyphicon glyphicon-menu-right",  // glyphicon-plus-sign
                expanderOpen: "glyphicon glyphicon-menu-down",  // glyphicon-collapse-down
                folder: "glyphicon glyphicon-folder-close",
                folderOpen: "glyphicon glyphicon-folder-open",
                loading: "glyphicon glyphicon-refresh glyphicon-spin"
            }
        };

        $(function() {
            $("#tabela").fancytree({
                extensions: ["dnd", "glyph", "table"],
                checkbox: false,
                dnd: {
                    focusOnClick: false,
                    dragStart: function(node, data) { return true; },
                    dragEnter: function(node, data) { return true; },
                    dragDrop: function (node, data) {
                        data.otherNode.moveTo(node, data.hitMode);
                        if (data.otherNode.parent.title != 'root') {
                            dep_pai = data.otherNode.parent.key;
                        } else {
                            dep_pai = '';
                        }


                        $.ajax({
                            url: '/departamento/' + data.otherNode.key + '/edit_tree',
                            method: 'POST',
                            data: {dep_cd_pai: dep_pai, _token: '{{csrf_token()}}', _method: 'PUT' },
                            success: function(result) {
                                if (result != 'ok') {
                                    alert(result);
                                }
                            },
                            error: function(result) {
                                alert(result);
                            }
                        });
                    }
                },
                glyph: glyph_opts,
                source: {url: "/departamento_tree/{{$id_empresa}}"},
                table: {
                    checkboxColumnIdx: 0,
                    nodeColumnIdx: 2
                },

                renderColumns: function (event, data) {
                    var node = data.node,
                        $tdList = $(node.tr).find(">td");
                    $tdList.eq(1).html('<a href="/departamento/'+node.key+'/edit"><span class="fa fa-edit"></a>');
                    //$tdList.eq(0).text(node.getIndexHier());
                    //$tdList.eq(3).text(!!node.folder);
                }
            });
        });

    </script>

@endsection