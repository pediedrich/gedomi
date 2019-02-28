@extends('main')

@section('title')
  <strong>Pasar expediente</strong>
@endsection
@section('content')
<!-- Default box -->
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">
      <span class="text-info">
        <strong>{{$expedient->number}}/{{$expedient->year->number}}</strong> "{{$expedient->title}}"
      </span>
     </h3>
  </div>
  <div class="box-body">
      {!! Form::model($expedient, ['route' => ['expedients.pass.confirmed', $expedient->id]]) !!}
      <div class="row">

        <!-- personal que tramita la causa -->
        <div class="form-group">
          <div class="col-md-6">
            <label class="control-label">Personal:</label>
            <select class="form-control" name="user_id">
              @foreach ($users as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-12">
            {{ Form::label('observ', 'Observación', ['class' => 'control-label']) }}
            {{ Form::text('observ', '', ['class' => 'form-control']) }}
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-2 pull-right">
            {{ Form::submit('Pasar',['class'=>'form-control btn btn-success']) }}
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
