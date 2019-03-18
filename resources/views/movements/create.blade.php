@extends('main')

@section('title')
  <div class="well well-sm panel panel-warning">
    <small>
      <strong>
        {{ $expedient->number }}/{{ $expedient->year()->first()->number }}
      </strong>
      "{{ $expedient->title }}"
     </small>
  </div>
@endsection

@section('content')
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Nueva Novedad</h3>
  </div>
  <div class="box-body">
      {!! Form::open(array('route' => array('expedient.novelty.store','id'=>$expedient->id), 'method' => 'POST')) !!}

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
                  {!! Form::checkbox('estado', null,array('class'=>'form-control selectpicker')) !!}
                  {!! $errors->first('estado', '<p class="help-block">:message</p>') !!}
              </div>
          </div>
      </div>
      {!! Form::submit('Guardar Cambios',['class' => 'btn btn-success pull-right ']) !!}
      {!! Form::close() !!}
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      {{-- <div class="box box-danger">
            <div class="box-header with-border">
              <h4>Importante!</h4>
              <p></p>

              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
      </div> --}}
    </div>
    <!-- /.box-footer-->
  </div>
@endsection
