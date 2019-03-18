@extends('main')

@section('content')

<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Editar Novedad</h3>
  </div>
  <div class="box-body">
      {!! Form::model($novelty, array('route' => array('expedient.novelty.update', $novelty->id), 'method' => 'POST')) !!}
      <div class="row">
          <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
              <div class="col-md-10">
                  {!! Form::label('title', 'Titulo') !!}
                  {!! Form::text('title', null, ['class' => 'form-control']) !!}
                  {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
              </div>
          </div>
      </div>
      <div class="row">
          <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
              <div class="col-md-10">
                  {!! Form::label('text', 'Novedad') !!}
                  {!! Form::textarea('text', null, ['id' => 'text','class' => 'form-control','cols'=>50,'rows'=>5]) !!}
                  {!! $errors->first('text', '<p class="help-block">:message</p>') !!}
              </div>
          </div>
      </div>
      <div class="row">
          <div class="form-group{{ $errors->has('estado') ? ' has-error' : '' }}">
              <div class="col-md-5">
                  {!! Form::label('estado', 'Publico') !!}
                  {!! Form::checkbox('estado',null,$novelty->public) !!}
                  {!! $errors->first('estado', '<p class="help-block">:message</p>') !!}
              </div>
          </div>
      </div>
        {!! Form::submit('Guardar Cambios',['class' => 'btn btn-success pull-right ']) !!}
        {!! Form::close() !!}
    </div>
    <!-- /.box-body -->
    <div class="box-footer">

    </div>
    <!-- /.box-footer-->
  </div>
@endsection
