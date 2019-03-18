@extends('main')

@section('content')
<!-- Default box -->
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title"><strong>Dar Salida expediente  </strong> <span class="text-info">"{{$expedient->number}}/{{$expedient->year->number}} {{$expedient->title}}"</span> </h3>
  </div>
  <div class="box-body">
      {!! Form::model($expedient, ['route' => ['expedients.egress.confirmed', $expedient->id]]) !!}
      <div class="row">
        <div class="form-group{{ $errors->has('observation') ? ' has-error' : '' }}">
          <div class="col-md-10">
            {{ Form::label('observation', 'Observación', ['class' => 'control-label']) }}
            {{ Form::textarea('observation', '', ['class' => 'form-control', 'rows' => 3, 'cols' => 20,'style' => 'resize:none']) }}
              {!! $errors->first('observation', '<p class="help-block">:message</p>')  !!}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-8 col-md-2">
            {{ Form::submit('Salida',['class'=>'form-control btn btn-success']) }}
          </div>
        </div>
      </div>
      {!! Form::close() !!}
  </div>
  <!-- /.box-body -->
  <div class="box-footer">
  </div>
  <!-- /.box-footer-->
</div>
<!-- /.box -->



@endsection
