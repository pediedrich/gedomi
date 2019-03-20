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
          <li >
            <a href="#files" data-toggle="tab">Documentos</a>
          </li>
    			<li >
            <a  href="#movements" data-toggle="tab">Movimientos</a>
          </li>
    			<li class="active">
            <a href="#passes" data-toggle="tab">Pases</a>
          </li>
          <li>
            <a href="#novelties" data-toggle="tab">Novedades</a>
          </li>
    		</ul>

  			<div class="tab-content clearfix">
          <div class="tab-pane" id="files">
            @if(!$expedient->files->count())
              <div class="list-group-item">
                <h5 class="list-group-item-heading text-warning">No hay Documentos para mostrar</h5>
              </div>
            @else
              @php
                $c=1;
              @endphp
              @foreach ($expedient->files as $file)
                <div class="list-group-item">
                  <div class="row">
                    <div class="col-md-1">
                      <span class="text-black">
                        {{$c}}#
                        <img src="{{ asset('img/'.$file->extension.'.png') }}" height="25" width="25" alt="">
                      </span>
                    </div>
                    <div class="col-md-10">
                      <span class="list-group-item-heading text-warning">
                        {{$file->title}}
                      </span>
                    </div>
                    <div class="col-md-1">
                      <span class="pull-right"><a class="btn btn-primary" href="{{ route('expedients.file.download',array('id' => $expedient->id,'file_id'=>$file->id)) }}"><i class="glyphicon glyphicon-download"></i></a></span>
                    </div>
                  </div>
                </div>
                @php
                  $c++;
                @endphp
              @endforeach
              @php
                unset($c);
              @endphp
            @endif
  				</div>
  			  <div class="tab-pane" id="movements">
            @if(!$expedient->movements->count())
              <div class="list-group-item">
                <h5 class="list-group-item-heading text-warning">No hay Movimientos</h5>
              </div>
            @else
              @php
                $c=1;
              @endphp
              @foreach ($expedient->movements as $movement)
                <div class="list-group-item">
                  <p>
                    <span class="text-black">
                      {{ $c }}#
                    </span>
                    <span class="text-warning">
                      {{ $movement->action }}
                    </span> <span class="text-black"> - Observación:
                      "{!! $movement->observation !!}"
                    </span>
                  </p>
                  <p>
                    <small class="text-muted">
                      <i class="glyphicon glyphicon-time"></i>
                      {{ $movement->created_at->format('d M Y H:m:s') }} - {{ $movement->user()->first()->name }}
                    </small>
                  </p>
                </div>
                @php
                  $c++;
                @endphp
              @endforeach
              @php
                unset($c);
              @endphp
            @endif
  				</div>
          <div class="tab-pane active" id="passes">
            @php
              $c = 1;
            @endphp
            @if(!$expedient->passes->count())
              <div class="list-group-item">
                <span class="text-black">{{ $c }}#</span><h5 class="list-group-item-heading text-warning">No hay Pases realizados</h5>
              </div>
            @else
              @foreach ($expedient->passes as $pass)
                <div class="list-group-item">
                  <p>
                    <span class="text-black">
                      {{ $c }}#
                    </span>
                    <span class="text-warning">
                      {{ $pass->userSender()->first()->name }}
                    </span>
                    <span class="text-black">el</span>
                    <span class="text-warning">
                      {{ $pass->created_at->format('d M Y H:m:s') }}
                    </span>
                    <span class="text-black">
                      pasó a
                    </span>
                    <span class="text-warning">
                      {{ $pass->userReceiver()->first()->name }}
                    </span>
                    <span class="text-black">
                      {!! $pass->observation ? 'Observación: "' .$pass->observation. '"' : '' !!}
                    </span>
                  </p>
                @php
                  $c++;
                @endphp
                </div>
              @endforeach
            @endif
            @php
              unset($c);
            @endphp
  				</div>
          <div class="tab-pane" id="novelties">
            @if(!$expedient->novelties->count())
              <div class="list-group-item">
                <h5 class="list-group-item-heading text-warning">No hay Novedades cargadas</h5>
              </div>
            @else
              @php
                $c = 1;
              @endphp
              @foreach ($expedient->novelties as $novelty)
                <div class="list-group-item">
                  <p>
                    <span class="text-black">
                      {{ $c }}#
                    </span>
                    <span class="list-group-item-heading text-warning">
                      {{ $novelty->title }}
                    </span>
                  </p>
                  <p class="list-group-item-text text-black">
                    {!! $novelty->text !!}
                  </p>
                </div>
              @endforeach
              @php
                unset($c);
              @endphp
            @endif
  				</div>
        </div>
    </div>
  </div>
</div>


@endsection
