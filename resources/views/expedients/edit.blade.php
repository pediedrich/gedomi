@extends('main')

@section('content')

<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Editar Expediente</h3>
    {!! Form::open(array('route' => array('expedients.destroy', $expedient->id), 'method' => 'delete')) !!}
    <button onclick="
            if (!confirm('Se va a eliminar permanentemente el usuario')) {
                return false;
            }
            ;" class="btn btn-danger pull-right" type="submit" >Eliminar Expediente</button>
    {!! Form::close() !!}
  </div>
  <div class="box-body">
    <form class="form-horizontal" method="POST" action="{{ route('expedients.update',['id' => $expedient->id]) }}">
      {{ csrf_field() }}
      {{ method_field('PATCH') }}
      <div class="form-group">
        <label class="control-label col-sm-2" for="title">Caratula</label>
        <div class="col-sm-10">
          <input type="title" class="form-control" id="title" value="{{$expedient->title}}" name="title">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2">Numero:</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="number" value="{{$expedient->number}}" name="number">
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2">Año:</label>
        <div class="col-sm-6">
          <select class="form-control" name="year_id">
            @foreach ($years as $key => $value)
              @if($key == $expedient->year_id)
              <option value="{{$key}}" selected="{{$expedient->year_id}}">{{$value}}</option>
              @endif
              <option value="{{$key}}">{{$value}}</option>
            @endforeach
          </select>
        </div>
      </div>

      <!-- personal que tramita la causa -->
      <!-- <div class="form-group">
        <label class="control-label col-sm-2">Instructor:</label>
        <div class="col-sm-6">
          <select class="form-control" name="user_id">
            <option value="1" selected>Juan Cruz</option>
            <option value="2">Gomez Carlos</option>
          </select>
        </div>
      </div> -->

      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-6">
          <button type="submit" class="btn btn-primary pull-right btn-block">Guardar</button>
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
