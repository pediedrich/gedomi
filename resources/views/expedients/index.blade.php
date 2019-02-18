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
    <h3 class="box-title">Listado Expedientes</h3>
    @permission('expedient_create')
    <div class="box-tools pull-right">
      <a href="{{ route('expedients.create') }}" class="btn btn-primary">+<span class="hidden-xs">Expte Nuevo</span></a>
    </div>
    @endpermission
  </div>
  <div class="box-body">
    @if (Session::has('flash_notification.message'))
            <div class="alert alert-{{ Session::get('flash_notification.level') }}">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('flash_notification.message') }}
            </div>
    @endif
    <table class="table" id="expedients-list">
      <thead class="thead-light">
        <tr>
          <th scope="col">Caratula</th>
          <th scope="col">Numero</th>
          <th scope="col">Documentos</th>
          <th scope="col">Pasado a</th>
          <th scope="col">Observación</th>
          <th scope="col">Recibido</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($expedients as $key => $expedient)
          <tr>
            <td>
              {{$expedient->title}}
            </td>
            <td>
              {{$expedient->number}}/{{$expedient->year->number}}
            </td>
            <td>
              {{$expedient->files()->count() }}
            </td>
            <td>
              {{$expedient->passes()->first()->userReceivers->display_name }}
            </td>
            <td>
              {{$expedient->passes()->first()->observation }}
            </td>
            @if ($expedient->passes()->first()->received_at != null)
              <td>
                <span class="label label-success">recibido</span>
              </td>
            @else
              <td>
                <span class="label label-danger">no recibido</span>
              </td>
            @endif
            <td>
                <!--actions-->
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">

                      @if ($expedient->passes()->first()->received_at === null && Auth::user()->hasRole('proveyente'))
                        <li><a href="{{ route('expedients.receive',array('id' => $expedient->id)) }}">Recibir</a></li>
                      @else
                        @permission('expedient_edit')
                          <li><a href="{{ route('expedients.edit',array('id' => $expedient->id)) }}">Editar</a></li>
                        @endpermission
                        @permission('expedient_show')
                          <li><a href="{{ route('expedients.show',array('id' => $expedient->id)) }}">Ingresar</a></li>
                        @endpermission
                      @endif
                    </ul>
                </div>
                <!--end actions-->
            </td>
          </tr>
        @endforeach

      </tbody>
    </table>
    {{-- {{ $expedients->links() }} --}}
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

    $('#expedients-list').DataTable({

    })
  })
</script>
@endsection

@endsection
