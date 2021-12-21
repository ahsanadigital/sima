@extends('layouts.panel')

@section('container')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h5 mb-0 text-gray-800">{{ $events->event_name }}</h1>
  <div class="btn-group">
    <a href="{{ route('events.edit', $events->id) }}" class="btn btn-primary"><i class="fas fa-pencil-alt"></i><span class="d-md-none ml-2 d-lg-inline d-none">Edit</span></a>
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
      <i class="fas fa-trash"></i><span class="ml-2 d-none d-lg-inline d-md-none">Delete</span>
    </button>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure to delete this event? If yes you'll no longger to see this data again.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
        <form action="{{ route('events.destroy', $events->id) }}" method="post">
          @method('DELETE')
          @csrf
          <button type="submit" class="btn btn-danger">Delete it!</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-4 mb-3">
    <div class="card card-body">
      @if($events->event_pict)
      <img src="{{ asset($events->event_pict) }}" alt="{{ $events->event_name }}" class="rounded w-100" />
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
              <td>{{ $events->event_name }}</td>
            </tr>
            <tr>
              <th>Event Description</th>
              <td>{{ $events->description }}</td>
            </tr>
            <tr>
              <th>Event Helded By</th>
              <td>{{ $events->event_creator }}</td>
            </tr>
            <tr>
              <th>Published By</th>
              <td><a href="#">{{ $events->author()->first()->fullname }}</a></td>
            </tr>
            <tr>
              <th>Held in</th>
              <td>
              @if($events->place == 'online')
              <i class="fas fa-fw fa-map-marker"></i><span class="ml-2">Online</span>
              @elseif($events->place == 'local')
              <i class="fas fa-fw fa-map-marker"></i><span class="ml-2">Offline (Local University)</span>
              @elseif($events->place == 'outside')
              <i class="fas fa-fw fa-map-marker"></i><span class="ml-2">Offline (Outsde University)</span>
              @endif
              </td>
            </tr>
            <tr>
              <th>Event Type</th>
              <td>
                {{ Str::ucfirst($events->event_type) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
