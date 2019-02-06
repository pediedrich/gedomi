@extends('main')

@section('content')

<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Nuevo Expediente</h3>
    <!-- <div class="box-tools pull-right">
      <a href="{{ route('expedients.create') }}" class="btn btn-primary">+<span class="hidden-xs">Expte Nuevo</span></a>
    </div> -->
  </div>
  <div class="box-body">
    <form class="form-horizontal" method="POST" action="{{ route('expedients.store') }}">
      {{ csrf_field() }}

      <!-- Caratula -->
      <div class="form-group">
        <label class="control-label col-sm-2" for="title">Caratula</label>
        <div class="col-sm-8">
          <input type="title" class="form-control" id="title" placeholder="ingrese caratula" name="title">
        </div>
      </div>

      <!-- Numero -->
      <div class="form-group">
        <label class="control-label col-sm-2">Numero:</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="number" placeholder="ingresar numero" name="number">
        </div>
      </div>


      <!-- Año -->
      <div class="form-group">
        <label class="control-label col-sm-2">Año:</label>
        <div class="col-sm-6">
          <select class="form-control" name="year_id">
            @foreach ($years as $key => $value)
              @if($value == $selected)
                <option value="{{$key}}" selected>{{$value}}</option>
              @else
                <option value="{{$key}}">{{$value}}</option>
              @endif
            @endforeach
          </select>
        </div>
      </div>

      <!-- tipo expediente -->
      <div class="form-group">
        <label class="control-label col-sm-2">Tipo Expte:</label>
        <div class="col-sm-6">
          <select class="form-control" name="type_id">
            @foreach ($types as $key => $value)
            <option value="{{$key}}" selected>{{$value}}</option>
            @endforeach
          </select>
        </div>
      </div>

      <!-- personal que tramita la causa -->
      <div class="form-group">
        <label class="control-label col-sm-2">Relator:</label>
        <div class="col-sm-6">
          <select class="form-control" name="user_id">
            <option value="1">Dra. Acosta</option>
            <option value="2">Dra. Ascencio</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-6">
          <button type="submit" class="btn btn-primary pull-right btn-block">Guardar y Pasar</button>
        </div>
      </div>
    </form>
  </div>
  <!-- /.box-body -->
  <div class="box-footer">

  </div>
  <!-- /.box-footer-->
</div>
<!-- /.box -->

@endsection
