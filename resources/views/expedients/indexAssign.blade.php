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
      @if(!isset($create))
        <div class="box-tools pull-right">
          <a href="{{ route('expedients.create') }}" class="btn btn-primary">+<span class="hidden-xs">Expte Nuevo</span></a>
        </div>
      @endif
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
          <th scope="col">fecha pase</th>
          <th scope="col">Observación</th>
          <th scope="col">estado</th>
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
              <!-- muestro el usuario a quien se le paso el condicional es por que la consulta es diferente dependiendo del caso -->
              @if ($expedient->passes()->whereReceivedAt(null)->first())
                {{ $expedient->passes()->whereReceivedAt(null)->first()->userReceiver()->first()->display_name }}
              @else
                {{ $expedient->passes()->get()->last()->userReceiver()->first()->display_name }}
              @endif
            </td>
            <td>
              <!-- muestro el usuario a quien se le paso el condicional es por que la consulta es diferente dependiendo del caso -->
              @if ($expedient->passes()->whereReceivedAt(null)->first())
                {{ $expedient->passes()->whereReceivedAt(null)->first()->created_at->format('d M Y') }}
              @else
                {{ $expedient->passes()->get()->last()->created_at->format('d M Y') }}
              @endif
            </td>
            <td>
              @if ($expedient->passes()->whereReceivedAt(null)->first())
                {{ $expedient->passes()->whereReceivedAt(null)->first()->observation }}
              @else
                {{ $expedient->passes()->get()->last()->observation }}
              @endif
            </td>
            @if (!$expedient->passes()->whereReceivedAt(null)->first())
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
                      <!-- menu en caso de coordinadores -->
                      @if(Auth::user()->hasRole('coordinador') || Auth::user()->hasRole('coordinador superior'))
                        <li><a href="{{ route('expedients.show',array('id' => $expedient->id)) }}">Entrar</a></li>
                        @permission('expedient_edit')
                        <li><a href="{{ route('expedients.edit',array('id' => $expedient->id)) }}">Editar</a></li>
                        @endpermission
                        <li><a href="{{ route('expedients.reassignPass',array('id' => $expedient->id)) }}">Reasignar</a></li>
                        @permission('expedient_egress')
                          <li><a href="{{ route('expedients.egress',array('id' => $expedient->id)) }}">Salida</a></li>
                        @endpermission
                        @permission('expedient_destroy')
                          <li><a href="{{ route('expedients.destroy',array('id' => $expedient->id)) }}">Eliminar</a></li>
                        @endpermission
                        <li><a href="{{ route('expedient.novelties',array('id' => $expedient->id)) }}">Novedades</a></li>
                        <li><a href="{{ route('expedient.movements',array('id' => $expedient->id)) }}">Movimientos</a></li>
                      @endif
                      @role('ministro')
                        <li><a href="{{ route('expedient.movements',array('id' => $expedient->id)) }}">Movimientos</a></li>
                        <li><a href="{{ route('expedient.novelties',array('id' => $expedient->id)) }}">Novedades</a></li>
                        <li><a href="{{ route('expedients.show',array('id' => $expedient->id)) }}">Entrar</a></li>
                      @endrole
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
  <div class="box-footer">

  </div>
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
