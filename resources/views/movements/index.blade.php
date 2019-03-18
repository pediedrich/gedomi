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
        <ul  class="nav nav-pills" >
    			<li class="active">
            <a  href="#movements" data-toggle="tab">Movimientos</a>
          </li>
    			<li>
            <a href="#passes" data-toggle="tab">Pases</a>
          </li>
    		</ul>

  			<div class="tab-content clearfix">
  			  <div class="tab-pane active" id="movements">
            @foreach ($movements as $movement)
              <div class="list-group-item">
                <h5 class="list-group-item-heading text-warning">{{ $movement->action }}</h5>
                <p class="list-group-item-text text-black">{!! $movement->observation !!}</p>
                  <small class="text-muted"><i class="glyphicon glyphicon-time"></i> {{ $movement->created_at->format('d M Y H:m:s') }} - {{ $movement->user()->first()->name }} </small>
                </p>
              </div>
            @endforeach
  				</div>
          <div class="tab-pane" id="passes">
            @foreach ($passes as $pass)
              <div class="list-group-item">
                <h5 class="list-group-item-heading text-warning">{{ $pass->userSender()->first()->name }} </h5>
                <p class="list-group-item-text text-black">{!! $pass->observation !!}</p>
              </div>
            @endforeach
  				</div>
        </div>
    </div>
  </div>
</div>


@endsection
