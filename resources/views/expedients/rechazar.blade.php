@extends('main')

@section('link-styles')
  <!-- DataTables -->
  <link rel="stylesheet" href="/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
<!-- Default box -->
<div class="box">
  @include('flash::message')
  <div class="box-header with-border">
    <h3 class="box-title">Rechazar pase</h3>
  </div>
  <div class="box-body">
    {!! Form::open(array('route' => array('expedients.rechazado', $expedient->id), 'method' => 'POST')) !!}
    <div class="row">
      <div class="form-group{{ $errors->has('observation') ? ' has-error' : '' }}">
        <div class="col-md-12">
          {!! Form::label('observation','Observación') !!}
          {!! Form::text('observation','',['class'=>'form-control']) !!}
          {!! $errors->first('observation', '<p class="help-block">:message</p>')  !!}
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-2 pull-right">
          {!! Form::submit('Guardar',['class'=>'form-control btn btn-success']) !!}
        </div>
      </div>
    </div>
    {!! Form::close() !!}
    {{-- {{ $expedients->links() }} --}}
  </div>
  <!-- /.box-body -->
  <!-- <div class="box-footer">

  </div> -->
  <!-- /.box-footer-->
</div>
<!-- /.box -->

@section('script-js')

  <!-- DataTables -->
  <script src="/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

  <script>
  $(function () {

    $('#expedients-list').DataTable({

    })
  })
</script>
@endsection

@endsection
