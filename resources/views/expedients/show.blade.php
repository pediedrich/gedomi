@extends('main')

@section('content')
  @permission(['files_upload','files_upload_admin'])
  <!-- Default box -->
  <div class="box box-pimary">
    <div class="box-header with-border">
      <h3 class="box-title"> Subir Documentos </h3>
    </div>
    <div class="box-body">

      <form method="POST" action="{{ route('expedient.file',['expedient_id'=>$expedient->id]) }}" accept-charset="UTF-8" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
          <div class="col-md-4">
            {{ Form::label('file', 'Archivo') }}
            {{ Form::file('file', null, ['class' => 'form-control']) }}
            {!! $errors->first('file', '<p class="help-block">:message</p>')  !!}
          </div>
        </div>

        <div class="form-group{{ $errors->has('typeFile_id') ? ' has-error' : '' }}">
          <div class="col-md-4">
            {{ Form::label('typeFile_id', 'Tipo Documento') }}
            {{ Form::select('typeFile_id', $typeFiles,null, ['class' => 'form-control']) }}
            {!! $errors->first('typeFile_id', '<p class="help-block">:message</p>')  !!}
          </div>
        </div>

        <div class="form-group{{ $errors->has('title_file') ? ' has-error' : '' }}">
          <div class="col-md-4">
            {{ Form::label('title_file', 'Titulo') }}
            {{ Form::text('title_file', null, ['class' => 'form-control']) }}
            {!! $errors->first('title_file', '<p class="help-block">:message</p>')  !!}
          </div>
        </div>

        <div class="form-group{{ $errors->has('title_file') ? ' has-error' : '' }}">
          <div class="col-md-12">
            {!! Form::submit('Guardar Cambios',['class' => 'btn btn-success pull-right ']) !!}
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
  @endpermission


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
          <th scope="col" class="col-md-1"></th>
          <th scope="col">Documento</th>
          <th scope="col">Tipo Documento</th>
        </tr>
      </thead>
      <tbody>
        <tr>
        @foreach ($expedient->files as $file)
            <td class="img img-responsive">
                <img src="{{ asset('img/'.$file->extension.'.png') }}" height="25" width="25" alt="">
            </td>
            <td>{{$file->title}}</td>
            <td>{{  $file->typeFile->name }}</td>
            <td>
                <!--actions-->
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        @permission('files_download')
                        <li><a href="{{ route('expedients.file.download',array('id' => $expedient->id,'file_id'=>$file->id)) }}">Descargar</a></li>
                        @endpermission
                        @permission('files_destroy')
                        <li><a href="{{ route('expedients.file.destroy',array('id' => $expedient->id,'file_id'=>$file->id)) }}">Eliminar</a></li>
                        @endpermission
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


@endsection
