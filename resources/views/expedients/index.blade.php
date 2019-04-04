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
    <table class="table table-striped" id="expedients-list">
      <thead class="thead-light">
        <tr>
          <th scope="col">Caratula</th>
          <th scope="col">Numero</th>
          <th scope="col">Documentos</th>
          @role(['coordinador superior','ministro'])
            <th scope="col">Recibido de</th>
          @endrole
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
            @role(['coordinador','ministro'])
              <td>
                @if ($expedient->passes()->whereReceivedAt(null)->first())
                  {{ $expedient->passes()->whereReceivedAt(null)->first()->userSender()->first()->display_name }}
                @else
                  {{ $expedient->passes()->get()->last()->userSender()->first()->display_name }}
                @endif
              </td>
            @endrole
            <td>
              @if ($expedient->passes()->count() && $expedient->passes()->whereReceivedAt(null)->first())
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
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu" style="background-color:lightgrey">
                      <!-- menu en caso de coordinadores -->
                      @if(Auth::user()->hasRole('coordinador') || Auth::user()->hasRole('coordinador superior'))
                        @if ($expedient->passes()->whereReceivedAt(null)->first())
                          <li><a href="{{ route('expedients.receive',array('id' => $expedient->id)) }}" class="text-black">Recibir</a></li>
                          <li><a href="{{ route('expedients.rechazar',array('id' => $expedient->id)) }}" class="text-black">Rechazar</a></li>
                        @else
                          <li><a href="{{ route('expedients.show',array('id' => $expedient->id)) }}" class="text-black">Entrar</a></li>
                          @if(Auth::user()->can('expedient_show_admin'))
                            <li><a href="{{ route('expedients.pass',array('id' => $expedient->id)) }}" class="text-black">Pasar</a></li>
                          @endif
                          @permission('expedient_edit')
                            <li><a href="{{ route('expedients.edit',array('id' => $expedient->id)) }}" class="text-black">Editar</a></li>
                          @endpermission
                          @permission('expedient_egress')
                            <li><a href="{{ route('expedients.egress',array('id' => $expedient->id)) }}" class="text-black">Salida</a></li>
                          @endpermission

                        @endif
                      @endif
                      <!-- menu en caso del relator -->
                      @if ($expedient->passes()->whereReceivedAt(null)->first() && Auth::user()->hasRole('relator'))
                        <li><a href="{{ route('expedients.receive',array('id' => $expedient->id)) }}" class="text-black">Recibir</a></li>
                        <li><a href="{{ route('expedients.rechazar',array('id' => $expedient->id)) }}" class="text-black">Rechazar</a></li>
                      @else
                        @permission('expedient_show')
                          <!-- <li><a href="{{ route('expedients.show',array('id' => \Crypt::encrypt($expedient->id))) }}">Entrar</a></li> -->
                          <li><a href="{{ route('expedients.show',array('id' => $expedient->id)) }}" class="text-black">Entrar</a></li>
                          <li><a href="{{ route('expedients.pass',array('id' => $expedient->id)) }}" class="text-black">Pasar</a></li>
                        @endpermission
                        @if (!$expedient->passes()->whereReceivedAt(null)->first())
                          <li><a href="{{ route('expedient.novelties',array('id' => $expedient->id)) }}" class="text-black">Novedades</a></li>
                          <li><a href="{{ route('expedient.movements',array('id' => $expedient->id)) }}" class="text-black">Movimientos</a></li>
                        @endif
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
