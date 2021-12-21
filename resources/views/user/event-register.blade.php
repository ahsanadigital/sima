@extends('layouts.panel')

@section('container')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h5 mb-0 text-gray-800">{{ $event->event_name }}</h1>
</div>

<div class="row">
  <div class="col-md-4 mb-3">
    <div class="card card-body">
      @if($event->event_pict)
      <img src="{{ asset($event->event_pict) }}" alt="{{ $event->event_name }}" class="rounded w-100" />
      @endif
    </div>
  </div>
  <div class="col-md-8">
    <div class="card card-body">
      <div class="table-responsive w-100">
        <table class="table w-100 m-0 table-bordered rounded table-striped">
          <tbody>
            <tr>
              <th>Event Name</th>
              <td>{{ $event->event_name }}</td>
            </tr>
            <tr>
              <th>Event Description</th>
              <td>{{ $event->description }}</td>
            </tr>
            <tr>
              <th>Event Helded By</th>
              <td>{{ $event->event_creator }}</td>
            </tr>
            <tr>
              <th>Published By</th>
              <td><a href="#">{{ $event->author()->first()->fullname }}</a></td>
            </tr>
            <tr>
              <th>Held in</th>
              <td>
              @if($event->place == 'online')
              <i class="fas fa-fw fa-map-marker"></i><span class="ml-2">Online</span>
              @elseif($event->place == 'local')
              <i class="fas fa-fw fa-map-marker"></i><span class="ml-2">Offline (Local University)</span>
              @elseif($event->place == 'outside')
              <i class="fas fa-fw fa-map-marker"></i><span class="ml-2">Offline (Outsde University)</span>
              @endif
              </td>
            </tr>
            <tr>
              <th>Event Type</th>
              <td>
                {{ Str::ucfirst($event->event_type) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <form method="POST" action="{{ route('event.process', $event->id) }}" class="mt-3">
        @csrf
        <button class="btn btn-success">Register</button>
      </form>
    </div>
  </div>
</div>
@endsection
