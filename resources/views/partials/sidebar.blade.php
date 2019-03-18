<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        {{-- <img src="/adminlte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"> --}}
      </div>
      <div class="pull-left image text-white">
        @if(Auth::user()->name)
          <p>{{Auth::user()->display_name}}</p>
          {{-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> --}}
        @endif
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MENU</li>
      <li class="treeview menu-open">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Expedientes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: block;">
            @ability('ministro','expedient_assign')
              <li {{ (Request::is('*expedients/assign/list*') ? 'class=active' : '') }}>
                <a href="{{ route('expedients.assign.list') }}"><i class="fa fa-circle-o"></i>Listado</a>
              </li>
            @endability
            @permission('expedient_ingress')
              <li {{ (Request::is('*expedients/ingress/now*') ? 'class=active' : '') }}>
                <a href="{{ route('expedients.ingress') }}"><i class="fa fa-circle-o"></i>Reingresar</a>
              </li>
            @endpermission

            @ability('coordinador,relator,coordinador superior','')
              <li {{ (Request::is('*expedients') ? 'class=active' : '') }}>
                <a href="{{ route('expedients.index') }}"><i class="fa fa-circle-o"></i>Mis Expedientes</a>
              </li>
            @endability
            <li {{ (Request::is('*expedients/search/list') ? 'class=active' : '') }}>
              <a href="{{ route('expedients.search.list') }}"><i class="fa fa-circle-o"></i>Consulta</a>
            </li>
          </ul>
      </li>
      @permission('user_list')
      <li {{ (Request::is('*users*') ? 'class=active' : '') }}><a href="{{ route('users.index') }}"><i class="fa fa-users"></i>Usuarios</a></li>
      @endpermission
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
