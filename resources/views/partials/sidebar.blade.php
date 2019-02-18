<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="/adminlte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        @if(Auth::user()->name)
          <p>{{Auth::user()->display_name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        @endif
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      @permission('expedient_list')
      <li {{ (Request::is('*expedients*') ? 'class=active' : '') }}><a href="{{ route('expedients.index') }}">Expedientes</a></li>
      @endpermission
      @permission('user_list')
      <li {{ (Request::is('*users*') ? 'class=active' : '') }}><a href="{{ route('users.index') }}">Usuarios</a></li>
      @endpermission
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
