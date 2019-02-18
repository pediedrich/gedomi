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
      <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
          <div class="col-md-8">
            {{ Form::label('title', 'Caratula') }}
            {{ Form::text('title', null, ['class' => 'form-control']) }}
            {!! $errors->first('title', '<p class="help-block">:message</p>')  !!}
          </div>
      </div>

      <!-- Numero -->
      <div class="form-group{{ $errors->has('number') ? ' has-error' : '' }}">
          <div class="col-md-6">
            {{ Form::label('number', 'Número') }}
            {{ Form::text('number', null, ['class' => 'form-control']) }}
            {!! $errors->first('number', '<p class="help-block">:message</p>')  !!}
          </div>
      </div>

      <!-- Año -->
      <div class="form-group">
        <div class="col-sm-6">
          <label class="control-label">Año:</label>
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
        <div class="col-sm-6">
          <label class="control-label">Tipo Expte:</label>
          <select class="form-control" name="type_id">
            @foreach ($types as $key => $value)
              <option value="{{$key}}">{{$value}}</option>
            @endforeach
          </select>
        </div>
      </div>

      <!-- personal que tramita la causa -->
      <div class="form-group">
        <div class="col-sm-6">
          <label class="control-label">Relator:</label>
          <select class="form-control" name="user_owner_id">
            @foreach ($userOwner as $key => $value)
              <option value="{{$key}}">{{$value}}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-group{{ $errors->has('observation') ? ' has-error' : '' }}">
          <div class="col-md-6">
            {{ Form::label('observation', 'Observación') }}
            {{ Form::text('observation', null, ['class' => 'form-control']) }}
            {!! $errors->first('observation', '<p class="help-block">:message</p>')  !!}
          </div>
      </div>

      <div class="form-group">
        <div class="pull-right col-sm-2">
          <button type="submit" class="btn btn-success pull-right btn-block">Guardar y Pasar</button>
        </div>
        {{-- <div class="pull-right col-sm-2">
          <button type="submit" class="btn btn-primary pull-right btn-block">Guardar</button>
        </div> --}}
      </div>

    </form>
  </div>
  <!-- /.box-body -->
  {{-- <div class="box-footer">

  </div> --}}
  <!-- /.box-footer-->
</div>
<!-- /.box -->

@endsection
