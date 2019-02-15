@extends('main')

@section('content')
<!-- Default box -->
<div class="box">
  @include('flash::message')
  <div class="box-header with-border">
    <h3 class="box-title">Listado Expedientes</h3>
    <div class="box-tools pull-right">
      <a href="{{ route('expedients.create') }}" class="btn btn-primary">+<span class="hidden-xs">Expte Nuevo</span></a>
    </div>
  </div>
  <div class="box-body">
    @if (Session::has('flash_notification.message'))
            <div class="alert alert-{{ Session::get('flash_notification.level') }}">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('flash_notification.message') }}
            </div>
    @endif
    <table class="table">
      <thead class="thead-light">
        <tr>
          <th scope="col">Caratula</th>
          <th scope="col">Numero</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($expedients as $key => $expedient)
          <tr>
            <td>{{$expedient->title}}</td>
            <td>{{$expedient->number}}/{{$expedient->year->number}}</td>
            <td>
                <!--actions-->
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ route('expedients.edit',array('id' => $expedient->id)) }}">Editar</a></li>
                        <li><a href="{{ route('expedients.show',array('id' => $expedient->id)) }}">Ingresar</a></li>
                    </ul>
                </div>
                <!--end actions-->
            </td>
          </tr>
        @endforeach

      </tbody>
    </table>
    {{ $expedients->links() }}
  </div>
  <!-- /.box-body -->
  <!-- <div class="box-footer">

  </div> -->
  <!-- /.box-footer-->
</div>
<!-- /.box -->

@endsection
