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
          <p>{{Auth::user()->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        @endif
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <li {{ (Request::is('*expedients*') ? 'class=active' : '') }}><a href="{{ route('expedients.index') }}">Expedientes</a></li>
      <!-- <li {{ (Request::is('*user*') ? 'class=active' : '') }}><a href="#">Usuarios</a></li> -->
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
