@extends('main')

@section('content')

<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Editar Usuario</h3>
    <div class="box-tools pull-right">
      @if(Entrust::can('user_destroy'))
        {!! Form::open(array('route' => array('users.destroy', $user->id), 'method' => 'delete')) !!}
        <button onclick="
                if (!confirm('Se va a eliminar permanentemente el usuario')) {
                    return false;
                }
                ;" class="btn btn-danger pull-right" type="submit" >Eliminar Usuario</button>
        {!! Form::close() !!}
      @endif
    </div>
  </div>
  <div class="box-body">
      {!! Form::model($user, array('route' => array('users.update', $user->id), 'files' => true, 'method' => 'PUT')) !!}
      <div class="row">
          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <div class="col-md-5">
                  {!! Form::label('email', 'E-mail') !!}
                  {!! Form::email('email', null, ['id' => 'email','class' => 'form-control']) !!}
                  {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
              </div>
          </div>
      </div>
      <div class="row">
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              <div class="col-md-5">
                  {!! Form::label('name', 'Nombre Usuario') !!}
                  {!! Form::text('name', null, ['class' => 'form-control']) !!}
                  {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
              </div>
          </div>
      </div>
      <div class="row">
          <div class="form-group{{ $errors->has('display_name') ? ' has-error' : '' }}">
              <div class="col-md-5">
                  {!! Form::label('display_name', 'Nombre') !!}
                  {!! Form::text('display_name', null, ['class' => 'form-control']) !!}
                  {!! $errors->first('display_name', '<p class="help-block">:message</p>') !!}
              </div>
          </div>
      </div>
      <div class="row">
          <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
              <div class="col-md-5">
                  {!! Form::label('role_id', 'Rol') !!}
                  {!! Form::select('role_id', $roles , $user->roles()->pluck('id'),array('class'=>'form-control selectpicker' , 'data-live-search'=>'true')) !!}
                  {!! $errors->first('role_id', '<p class="help-block">:message</p>') !!}
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
