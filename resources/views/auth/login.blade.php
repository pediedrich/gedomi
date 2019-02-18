@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">

        <div class="col-md-8 col-md-offset-2">
          @if (session()->has('flash'))
            <div class="alert alert-danger center"><strong>{{ session('flash') }}</strong></div>
          @endif
            <div class="panel panel-default">
                <div class="panel-heading">
                  <!-- <div class="panel-title"> -->
                    Acceso al Sistema
                    <!-- <div> -->
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nombre de Usuario</label>
                              <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"  autofocus>
                              {!! $errors->first('name','<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña</label>
                                <input id="password" type="password" class="form-control" name="password" >
                                {!! $errors->first('password','<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Ingresar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
