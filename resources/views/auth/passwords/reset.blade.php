@extends('main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                  @if (isset($id))
                    <form class="form-horizontal" method="POST" action="{{route('reset-password',['user_id'=>$id])}}">
                  @else
                    <form class="form-horizontal" method="POST" action="{{route('reset-password')}}">
                  @endif
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                          <div class="col-md-6">
                            {{ Form::label('password','Ingresar su nueva clave') }}
                            {{ Form::password('password',['class'=>'form-control']) }}
                            {!! $errors->first('password','<p class="help-block">:message</p>') !!}
                          </div>
                        </div>

                        <div class="form-group{{ $errors->has('password-confirm') ? ' has-error' : '' }}">
                          <div class="col-md-6">
                            {{ Form::label('password-confirm','Confirmarsu nueva clave') }}
                            {{ Form::password('password-confirm',['class'=>'form-control']) }}
                            {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
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
