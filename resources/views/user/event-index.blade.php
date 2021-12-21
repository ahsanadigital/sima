@extends('layouts.panel')

@section('container')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">All Event</h1>
</div>

@if ($count == 0)
<div class="row justify-content-center">
  <div class="col-md-5 text-center">
    <img src="{{ asset('images/empty-event.svg') }}" alt="Empty State" class="mb-3" height="200px" />

    <h3>Sorry</h3>
    <p>There are not any event, please wait for several day until admin added some event(s).</p>
  </div>
</div>
@else
<div class="row">
  @foreach ($events as $event)
  <div class="col-md-6 mb-3">
    <div class="card shadow border-0">
      <div class="row no-gutters align-items-center">
        @if($event->event_pict)
        <div class="col-lg-4">
          <img src="{{ asset($event->event_pict) }}" alt="{{ $event->event_name }}" class="rounded w-100 ml-2" />
        </div>
        @endif
        <div class="col-lg-8">
          <div class="card-body">
            <a href="{{ route('event.register', $event->id) }}">
              <h3 class="h5">{{ $event->event_name }}</h3>
            </a>
            <ul class="list-unstyled mb-0">
              @if($event->place == 'online')
              <li><i class="fas fa-fw fa-map-marker"></i><span class="ml-2">Online</span></li>
              @elseif($event->place == 'local')
              <li><i class="fas fa-fw fa-map-marker"></i><span class="ml-2">Offline (Local University)</span></li>
              @elseif($event->place == 'outside')
              <li><i class="fas fa-fw fa-map-marker"></i><span class="ml-2">Offline (Outsde University)</span></li>
              @endif
              <li><i class="fas fa-fw fa-coins"></i><span class="ml-2">{{ $event->funded == true ? 'Funded' : 'Not Funded' }}</span></li>
              <li><i class="fas fa-fw fa-calendar"></i><span class="ml-2">{{ \Carbon\Carbon::parse($event->start_time)->format('l, j M Y') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('l, j M Y') }}</span></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>
@endif

<div class="my-3">
  {!! $events->links() !!}
</div>
@endsection
