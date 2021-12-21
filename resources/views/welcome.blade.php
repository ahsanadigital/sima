@extends('layouts.panel')

@section('container')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Content -->
<div class="row">
  <div class="col-md-7 mb-4">
    <div class="card-body card shadow">
      <div class="row">
        <div class="col-3">
          @auth('admin')
            @if (auth()->guard('admin')->user()->pp)
              <img src="{{ auth()->guard('admin')->user()->pp }}" alt="{{ auth()->guard('admin')->user()->fullname }}" class="w-100 rounded-circle" />
            @else
              <img src="{{ Gravatar::src(auth()->guard('admin')->user()->email) }}" alt="{{ auth()->guard('admin')->user()->fullname }}" class="w-100 rounded-circle" />
            @endif
          @endauth

          @auth('user')
            @if (auth()->guard('user')->user()->pp)
              <img src="{{ auth()->guard('user')->user()->pp }}" alt="{{ auth()->guard('user')->user()->fullname }}" class="w-100 rounded-circle" />
            @else
              <img src="{{ Gravatar::src(auth()->guard('user')->user()->email) }}" alt="{{ auth()->guard('user')->user()->fullname }}" class="w-100 rounded-circle" />
            @endif
          @endauth
        </div>
        <div class="col-9">
          @auth('admin')
          <h1 class="h3">{{ auth()->guard('admin')->user()->fullname }}</h1>
          <p><span class="badge badge-primary">Administrator</span></p>
          <p>{{ auth()->guard('admin')->user()->email }}</p>
          @endauth

          @auth('user')
          <h1 class="h3">{{ auth()->guard('user')->user()->fullname }}</h1>
          <p>{{ auth()->guard('user')->user()->email }}</p>

          <p><i class="fas fa-graduation-cap mr-2"></i>{{ auth()->guard('user')->user()->study }}</p>
          <p><i class="fas fa-building mr-2"></i>{{ auth()->guard('user')->user()->university }}</p>
          @endauth

          <div><a href="{{ route('user-edit.home') }}" class="btn btn-primary"><i class="fas fa-pencil-alt mr-2"></i><span>Edit Profile</span></a></div>
        </div>
      </div>
    </div>

    @auth('user')
    <div class="card card-body shadow border-0 mt-3">
      <div class="d-flex mb-3 justify-content-between">
        <h3>Notification</h3>
        <div><a href="{{ url('/notification') }}" class="btn btn-primary">Look All</a></div>
      </div>
    </div>
    @endauth
  </div>
  <div class="col-md-5 mb-4">
    <div class="card card-body shadow">
      <h3>Nearest Event</h3>

      <div class="table-responsive">
        <table class="table-striped table table-bordered rounded">
          <thead>
            <th>Event Name</th>
            <th>Held On</th>
          </thead>
          @if ($event_count > 0)
          <tbody>
            @foreach ($event_nearest as $event)
            <tr>
              <td>{{ $event->event_name }}</td>
              <td>{{ \Carbon\Carbon::parse($event->start_time)->format('l, j F Y') }}</td>
            </tr>
            @endforeach
          </tbody>
          @else
          <tbody>
            <tr>
              <td colspan="2">No Data</td>
            </tr>
          </tbody>
          @endif
        </table>
      </div>

    </div>
  </div>

  <div class="col-md-12 mb-4">
    <div class="card card-body shadow">
      <div class="d-flex justify-content-between mb-3">
        <h3>All Event</h3>
        <div>
          <a href="{{ route('event.index') }}" class="btn btn-primary">All Events</a>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table-striped table table-bordered rounded">
          <thead>
            <th>Event Name</th>
            <th>Type</th>
            <th>Held On</th>
          </thead>
          @if ($event_count > 0)
          <tbody>
            @foreach ($event_new as $event)
            <tr>
              <td><a href="@if(auth()->guard('user')->user()) {{ route('event.register', $event->id) }} @elseif(auth()->guard('user')->user()) {{ route('events.show', $event->id) }} @endif">{{ $event->event_name }}</a></td>
              <td>{{ Str::ucfirst($event->event_type) }}</td>
              <td>{{ \Carbon\Carbon::parse($event->start_time)->format('l, j F Y') }}</td>
            </tr>
            @endforeach
          </tbody>
          @else
          <tbody>
            <tr>
              <td colspan="2">No Data</td>
            </tr>
          </tbody>
          @endif
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
