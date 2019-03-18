@extends('main')

@section('link-styles')
  <link rel="stylesheet" href="/css/movements/index.css">
@endsection
@section('title')
  <div class="well well-sm panel panel-warning">
    <small>
      <strong>
        {{ $expedient->number }}/{{ $expedient->year()->first()->number }}
      </strong>
      "{{ $expedient->title }}"
     </small>
  </div>
  @include('flash::message')
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
      <div id="exTab1">
        <ul  class="nav nav-pills">
          <li class="active">
            <a href="#files" data-toggle="tab">Documentos</a>
          </li>
    			<li >
            <a  href="#movements" data-toggle="tab">Movimientos</a>
          </li>
    			<li>
            <a href="#passes" data-toggle="tab">Pases</a>
          </li>
          <li>
            <a href="#novelties" data-toggle="tab">Novedades</a>
          </li>
    		</ul>

  			<div class="tab-content clearfix">
          <div class="tab-pane active" id="files">
            @if(!$expedient->files->count())
              <div class="list-group-item">
                <h5 class="list-group-item-heading text-warning">No hay Documentos para mostrar</h5>
              </div>
            @else
              @foreach ($expedient->files as $file)
                <div class="list-group-item">
                  <div class="row">
                    <div class="col-md-11">
                      <h5 class="list-group-item-heading text-warning">{{$file->title}}</h5>
                    </div>
                    <div class="col-md-1">
                      <span class="pull-right"><a class="btn btn-primary" href="{{ route('expedients.file.download',array('id' => $expedient->id,'file_id'=>$file->id)) }}">Descargar</a></span>
                    </div>
                  </div>
                </div>
              @endforeach
            @endif
  				</div>
  			  <div class="tab-pane" id="movements">
            @if(!$expedient->movements->count())
              <div class="list-group-item">
                <h5 class="list-group-item-heading text-warning">No hay Movimientos</h5>
              </div>
            @else
              @foreach ($expedient->movements as $movement)
                <div class="list-group-item">
                  <h5 class="list-group-item-heading text-warning">{{ $movement->action }}</h5>
                  <p class="list-group-item-text text-black">{!! $movement->observation !!}</p>
                    <small class="text-muted"><i class="glyphicon glyphicon-time"></i> {{ $movement->created_at->format('d M Y H:m:s') }} - {{ $movement->user()->first()->name }} </small>
                  </p>
                </div>
              @endforeach
            @endif
  				</div>
          <div class="tab-pane" id="passes">
            @if(!$expedient->passes->count())
              <div class="list-group-item">
                <h5 class="list-group-item-heading text-warning">No hay Pases realizados</h5>
              </div>
            @else
              @foreach ($expedient->passes as $pass)
                <div class="list-group-item">
                  <h5 class="list-group-item-heading text-warning">{{ $pass->userSender()->first()->name }} </h5>
                  <p class="list-group-item-text text-black">{!! $pass->observation !!}</p>
                </div>
              @endforeach
            @endif
  				</div>
          <div class="tab-pane" id="novelties">
            @if(!$expedient->novelties->count())
              <div class="list-group-item">
                <h5 class="list-group-item-heading text-warning">No hay Novedades cargadas</h5>
              </div>
            @else
              @foreach ($expedient->novelties as $novelty)
                <div class="list-group-item">
                  <h5 class="list-group-item-heading text-warning">{{ $novelty->title }} </h5>
                  <p class="list-group-item-text text-black">{!! $novelty->text !!}</p>
                </div>
              @endforeach
            @endif
  				</div>
        </div>
    </div>
  </div>
</div>


@endsection
