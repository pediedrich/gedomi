@extends('main')

@section('content')
<!-- Default box -->
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">{{$expedient->number}}/{{$expedient->year->number}} "{{$expedient->title}}" </h3>
    <!-- <div class="box-tools pull-right">
      <a href="{{ route('files.create') }}" class="btn btn-primary">+<span class="hidden-xs">Nuevo Documento</span></a>
    </div> -->
  </div>
  <div class="box-body">
    <table class="table">
      <thead class="thead-light">
        <tr>
          <th scope="col">Documento</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($expedient->files as $file)
          <tr>
            <td>{{$file->title}}</td>
            <td>
                <!--actions-->
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ route('expedients.file.download',array('id' => $expedient->id,'file_id'=>$file->id)) }}">Descargar</a></li>
                    </ul>
                </div>
                <!--end actions-->
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <!-- /.box-body -->
  <div class="box-footer">

  </div>
  <!-- /.box-footer-->
</div>
<!-- /.box -->



<!-- Default box -->
<div class="box box-pimary">
  <div class="box-header with-border">
    <h3 class="box-title"> Subir Documentos </h3>
  </div>
  <div class="box-body">

    <form method="POST" action="{{ route('expedient.file',['expedient_id'=>$expedient->id]) }}" accept-charset="UTF-8" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
            <label for="file" class="col-md-4 control-label">Archivo</label>
            <div class="col-md-6">
                <input type="file" class="form-control" name="file" >
                @if ($errors->has(''))
                    <span class="help-block">
                        <strong>{{ $errors->first('') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('title_file') ? ' has-error' : '' }}">
            <label for="title_file" class="col-md-4 control-label">Titulo</label>
            <div class="col-md-6">
                <input id="title_file" type="title_file" class="form-control" name="title_file" >
                @if ($errors->has('title_file'))
                    <span class="help-block">
                        <strong>{{ $errors->first('title_file') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary pull-right">
                    Enviar
                </button>
            </div>
        </div>
      </form>
  </div>
  <!-- /.box-body -->
  <div class="box-footer">

  </div>
  <!-- /.box-footer-->
</div>
<!-- /.box -->
@endsection
