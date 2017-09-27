<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">PARÂMETROS</li>
            <!-- Optionally, you can add icons to the links -->
            <li><a href="{{route('empresa.index')}}"><i class="fa fa-bank"></i><span>Empresas</span></a></li>
            <li><a href="{{route('departamento.index')}}"><i class="fa fa-cube"></i><span>Departamentos</span></a></li>
            <li><a href="{{route('funcao.index')}}"><i class="fa fa-graduation-cap"></i><span>Funções</span></a></li>
            <li class="header">SEGURANÇA</li>
            <li><a href="{{route('grupo.index')}}"><i class="fa fa-users"></i><span>Grupo de Usuários</span></a></li>
            <li><a href="{{route('usuario.index')}}"><i class="fa fa-user"></i><span>Usuários</span></a></li>
            <li><a href="{{route('permissaogrupo.index')}}"><i class="fa fa-unlock-alt"></i><span>Permissão por Grupo</span></a></li>
            <li><a href="{{route('permissaofuncao.index')}}"><i class="fa fa-unlock-alt"></i><span>Permissão por Função</span></a></li>
            <!--
                                                <li><a href="#"><i class="fa fa-dashboard"></i><span>Another Link</span></a></li>
                                                <li class="treeview">
                                                    <a href="#"><i class="fa fa-dashboard"></i><span>Multilevel</span> <i class="fa fa-angle-left pull-right"></i></a>
                                                    <ul class="treeview-menu">
                                                        <li><a href="#"><i class="fa fa-dashboard"></i>Link in level 2</a></li>
                                                        <li><a href="#"><i class="fa fa-dashboard"></i>Link in level 2</a></li>
                                                    </ul>
                                                </li>
                                                -->
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
