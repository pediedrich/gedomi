@extends('main')


@section('link-styles')
  <!-- DataTables -->
  <link rel="stylesheet" href="/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')


<!-- Default box -->
<div class="box">
  @include('flash::message')
  <div class="box-header with-border">
    <h3 class="box-title">Listado Usuarios</h3>
    <div class="box-tools pull-right">
      <a href="{{ route('users.create') }}" class="btn btn-primary">+<span class="hidden-xs">Usuario Nuevo</span></a>
    </div>
  </div>
  <div class="box-body">

    <table class="table" id="users-list">
      <thead class="thead-light">
        <tr>
          <th scope="col">Nombre</th>
          <th scope="col">Usuario</th>
          {{-- <th scope="col">Email</th> --}}
          <th scope="col">Rol</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $key => $user)
          <tr>
            <td>{{$user->display_name }}</td>
            <td>{{$user->name}}</td>
            {{-- <td>{{$user->email}}</td> --}}
            <td>{{$user->roles()->first()->display_name }}</td>
            <td>
                <!--actions-->
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ route('users.edit',array('id' => $user->id)) }}">Editar</a></li>
                        <li><a href="{{ url('change-password',array('user_id' => $user->id)) }}">Cambiar Contrseña</a></li>
                    </ul>
                </div>
                <!--end actions-->
            </td>
          </tr>
        @endforeach

      </tbody>
    </table>
    {{-- {{ $users->links() }} --}}
  </div>
  <!-- /.box-body -->
  <!-- <div class="box-footer">
  </div> -->
  <!-- /.box-footer-->
</div>
<!-- /.box -->

@section('script-js')

  <!-- DataTables -->
  <script src="/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

  <script>
  $(function () {

    $('#users-list').DataTable({

    })
  })
</script>
@endsection

@endsection
