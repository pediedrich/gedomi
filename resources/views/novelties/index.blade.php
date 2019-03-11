@extends('main')

@section('link-styles')
  <link rel="stylesheet" href="/css/novelty/index.css">
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
  <div class="box-tools pull-right">
    <a href="{{ route('expedient.novelty.create',array('id'=> $expedient->id)) }}" class="btn btn-primary">+<span class="hidden-xs">Cargar Novedad</span></a>
  </div>
@endsection

@section('content')

    {{-- si es privado, muestro solo al usuario que creo y al ministro --}}
    @foreach ($novelties as $novelty)
      @if (!$novelty->public)
        @if ($novelty->user_id == Auth::user()->id || Auth::user()->hasRole('ministro'))
          <ul class="timeline">
            <li>
              @if ($novelty->public)
                <div class="timeline-badge success"><i class="fa  fa-unlock-alt"></i></div>
              @else
                <div class="timeline-badge danger"><i class="fa  fa-lock"></i></div>
              @endif
              <div class="timeline-panel ">
                <div class="timeline-heading">
                  <h4 class="timeline-title">{{ $novelty->title }}</h4>
                </div>
                <div class="timeline-body">
                  <p>{{ $novelty->text }}</p>
                  <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> {{ $novelty->created_at->format('d M Y H:m:s') }} - {{ $novelty->user()->first()->name }} </small></p>
                  <div class="btn-group pull-right">
                      {!! Form::open(array('url' => route('novelties.destroy', ['id' => $novelty->id]), 'onsubmit' => 'return confirmDelete()')) !!}
                      {{ method_field('DELETE') }}
                      <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                        <a href="{{ route('expedient.novelty.edit',array('id'=>$novelty->id)) }}" class="btn btn-primary" name="button">Editar</a>
                        {!! Form::submit('eliminar',['class' => 'btn btn-danger'])!!}
                      </div>
                      {!! Form::close() !!}
                  </div>
                </div>
              </div>
            </li>
          </ul>
        @endif
      @else
        <ul class="timeline">
          <li>
            <div class="timeline-badge success"><i class="fa  fa-unlock-alt"></i></div>
            <div class="timeline-panel ">
              <div class="timeline-heading">
                <h4 class="timeline-title">{{ $novelty->title }}</h4>
              </div>
              <div class="timeline-body">
                <p>{{ $novelty->text }}</p>
                <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> {{ $novelty->created_at->format('d M Y H:m:s') }} - {{ $novelty->user()->first()->name }} </small></p>
                <div class="btn-group pull-right">
                    {!! Form::open(array('url' => route('novelties.destroy', ['id' => $novelty->id]), 'onsubmit' => 'return confirmDelete()')) !!}
                    {{ method_field('DELETE') }}
                    <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                      <a href="{{ route('expedient.novelty.edit',array('id'=>$novelty->id)) }}" class="btn btn-primary" name="button">Editar</a>
                      {!! Form::submit('eliminar',['class' => 'btn btn-danger'])!!}
                    </div>
                    {!! Form::close() !!}
                </div>
              </div>
            </div>
          </li>
        </ul>
      @endif
    @endforeach

<script type="text/javascript">
  function confirmDelete() {
    return confirm('Seguro desea eliminar?');
  }
</script>

@endsection
