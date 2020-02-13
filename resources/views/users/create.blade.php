@extends('main')

@section('content')
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Nuevo Usuario</h3>
  </div>
  <div class="box-body">
      {!! Form::open(array('route' => array('users.store'), 'method' => 'POST')) !!}
      {{-- <div class="row">
          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <div class="col-md-5">
                  {!! Form::label('email', 'E-mail') !!}
                  {!! Form::email('email', old('email'), ['id' => 'email','class' => 'form-control','placeholder' => 'pablo@gmail.com']) !!}
                  {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
              </div>
          </div>
      </div> --}}
      <div class="row">
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              <div class="col-md-5">
                  {!! Form::label('name', 'Nombre de Usuario') !!}
                  {!! Form::text('name', null, ['class' => 'form-control','placeholder' => 'pablo']) !!}
                  {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
              </div>
          </div>
      </div>
      <div class="row">
          <div class="form-group{{ $errors->has('display_name') ? ' has-error' : '' }}">
              <div class="col-md-5">
                  {!! Form::label('display_name', 'Nombre Real') !!}
                  {!! Form::text('display_name', null, ['id' => 'display_name','class' => 'form-control','placeholder' => 'Diedrich Pablo']) !!}
                  {!! $errors->first('display_name', '<p class="help-block">:message</p>') !!}
              </div>
          </div>
      </div>
      <div class="row">
          <div class="form-group{{ $errors->has('rol_id') ? ' has-error' : '' }}">
              <div class="col-md-5">
                  {!! Form::label('rol_id', 'Rol') !!}
                  {!! Form::select('rol_id', $roles , null,array('class'=>'form-control selectpicker' , 'data-live-search'=>'true')) !!}
                  {!! $errors->first('rol_id', '<p class="help-block">:message</p>') !!}
              </div>
          </div>
      </div>
      {!! Form::submit('Guardar Cambios',['class' => 'btn btn-success pull-right ']) !!}
      {!! Form::close() !!}
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      <div class="box box-danger">
            <div class="box-header with-border">
              <h4>Importante!</h4>
              <p>La contraseña del presente usuario sera el mismo que el nombre. El usuario podra cambiar una vez que ingrese al sistema.-</p>

              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
      </div>
    </div>
    <!-- /.box-footer-->
  </div>
@endsection
