@extends('layouts.panel')

@section('header')
<link rel="stylesheet" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/dropify/css/dropify.min.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.css" integrity="sha256-sLwRL/qtJfexkqtTKT75YAL+pO2+XS1rhfIH0IL4SkU=" crossorigin="anonymous">

<style>
  .dropify-wrapper p {
    font-size: 1rem;
  }
  .dropify-wrapper {
    border: 2px dashed #eaeaea;
    border-radius: .5rem;
  }
</style>
@endsection

@section('container')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Edit Event</h1>
</div>

<form enctype="multipart/form-data" action="{{ route('events.update', $events->id) }}" method="POST" class="row">
  @csrf

  @method('PUT')

  <div class="col-md-4">
    <div class="card card-body shadow border-0">
      <input type="file" id="event_pict" class="filepond" name="event_pict" data-allow-reorder="true" data-max-file-size="3MB" data-max-files="3" />

      @if($events->event_pict)
      <div class="mt-3">
        <img src="{{ asset($events->event_pict) }}" alt="{{ $events->event_name }}" class="rounded w-100" />
      </div>
      @endif
    </div>
  </div>
  <div class="col-md-8">
    <div class="card card-body shadow border-0">

      <div class="form-group">
        <label for="event_name">Event Name</label>
        <input type="text" id="event_name" name="event_name" class="form-control" value="{{ old('event_name') ? old('event_name') : $events->event_name }}" placeholder="Enter the event name" />
      </div>

      <div class="form-group">
        <label for="event_creator">Event Creator</label>
        <input type="text" id="event_creator" name="event_creator" value="{{ old('event_creator') ? old('event_creator') : $events->event_creator }}" class="form-control" placeholder="Enter the event creator" />
      </div>

      <div class="form-group">
        <label for="date">Event Helded</label>
        <input type="text" id="date" name="date" class="form-control" placeholder="Enter the start and end date event" />
      </div>

      <div class="form-group">
        <label for="place">Event Helded In</label>
        <select name="place" id="place" class="form-control">
          <option disabled="disabled" selected>Choose One</option>
          <option @if($events->place == 'online' or old('place') == 'online') selected @endif value="online">Online</option>
          <option @if($events->place == 'local' or old('place') == 'local') selected @endif value="local">Offline (Local)</option>
          <option @if($events->place == 'outside' or old('place') == 'outside') selected @endif value="outside">Outside (Local)</option>
        </select>
      </div>

      <div class="collapse form-group" id="event_url">
        <label for="event_url">URL Event (If Online)</label>
        <input type="text"{{ old('event_url') ? " value=\"" . old('event_url') . "\"" : $events->event_url }} class="form-control" id="event_url" placeholder="Enter your event url" name="event_url" />
      </div>

      <div class="form-group">
        <label for="event_type">Event Type</label>
        <select name="event_type" id="event_type" class="form-control">
          <option disabled selected>Choose One</option>
          <option  @if($events->event_type == 'seminar' or old('event_type') == 'seminar') selected @endif value="seminar">Seminar</option>
          <option  @if($events->event_type == 'scholarship' or old('event_type') == 'scholarship') selected @endif value="scholarship">Scholarship</option>
          <option  @if($events->event_type == 'competition' or old('event_type') == 'competition') selected @endif value="competition">Competition</option>
          <option  @if($events->event_type == 'volunteer' or old('event_type') == 'volunteer') selected @endif value="volunteer">Volunteer</option>
        </select>
      </div>

      <div class="form-group">
        <label for="funded">Funded?</label>
        <select name="funded" id="funded" class="form-control">
          <option disabled="disabled" selected>Choose One</option>
          <option @if($events->funded == true or old('funded') == true) selected @endif value="true">Yes</option>
          <option @if($events->funded == false or old('funded') == false) selected @endif value="false">No</option>
        </select>
      </div>

      <div class="form-group">
        <label for="description">Event Description</label>
        <textarea name="description" id="description" rows="5" class="form-control">{{ old('description') ? old('description') : $events->description }}</textarea>
      </div>

      <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i><span class="ml-2">Simpan</span></button>

    </div>
  </div>
</form>
@endsection

@section('footer')
<script src="{{ asset('vendor/dropify/js/dropify.js') }}"></script>
<script src="{{ asset('vendor/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
$('#event_pict').dropify();

$('#date').daterangepicker({
  startDate : '{{ \Carbon\Carbon::parse($events->start_time)->format("m/d/Y") }}',
  endDate : '{{ \Carbon\Carbon::parse($events->end_time)->format("m/d/Y") }}',
});
$('select, #event_type').select2({ theme: 'bootstrap4' });

$('#place').on("select2:select", function(e) {
  console.log(e, e.params.data, e.params.data.id, e.params.data.id == 'online');

  if(e.params.data.id == 'online') {
    $('.collapse#event_url').collapse('show');
  } else {
    $('.collapse#event_url').collapse('hide');
  }
});
</script>
@endsection
