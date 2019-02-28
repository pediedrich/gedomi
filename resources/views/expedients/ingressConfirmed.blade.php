@extends('main')

@section('content')
<!-- Default box -->
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title"><strong>Reingresar expediente</strong> <span class="text-info">"{{$expedient->number}}/{{$expedient->year->number}} {{$expedient->title}}"</span> </h3>
  </div>
  <div class="box-body">
      {!! Form::model($expedient, ['route' => ['expedients.ingress.confirmed', $expedient->id]]) !!}

      <div class="row">

        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('observ', 'Observación', ['class' => 'control-label']) }}
            {{ Form::textarea('observ', '', ['class' => 'form-control', 'rows' => 6, 'cols' => 30,'style' => 'resize:none']) }}
          </div>
        </div>

        <div class="form-group">
          &nbsp;
        </div>

        <div class="form-group">
          <div class="col-md-2 pull-right">
            {{ Form::submit('Reingresar',['class'=>'form-control btn btn-success']) }}
          </div>
        </div>

      </div>

  </div>
  <!-- /.box-body -->
  <div class="box-footer">
  </div>
  <!-- /.box-footer-->
</div>
<!-- /.box -->



@endsection
