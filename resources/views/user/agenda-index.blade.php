@extends('layouts.panel')

@section('header')
<link rel="stylesheet" href="{{ asset('vendor/fullcalendar/main.min.css') }}" />
@endsection

@section('container')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">All My Agenda</h1>
</div>

<!-- Modal -->
<div class="modal fade" id="eventInfo" data-keyboard="false" tabindex="-1" aria-labelledby="eventInfoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eventInfoLabel">Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="table-responsive">
          <table class="table-responsive table" id="info-table">
            <tbody>
              <tr>
                <th>Event Name</th>
                <td><span id="event_name"></span></td>
              </tr>
              <tr>
                <th>Event Start</th>
                <td><span id="event_start"></span></td>
              </tr>
              <tr>
                <th>Event Description</th>
                <td><span id="description"></span></td>
              </tr>
              <tr class="collapse" id="event_url_collapse">
                <th>Event URL</th>
                <td><a href="" id="event_url"><span id="event_url"></span></a></td>
              </tr>
              <tr>
                <th>Event Place</th>
                <td><span id="place"></span></td>
              </tr>
              <tr>
                <th>Event Funded</th>
                <td><span id="funded"></span></td>
              </tr>
              <tr>
                <th>Event Type</th>
                <td><span id="event_type"></span></td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>

        <form action="" id="deleteEvent" method="post">
          @csrf
          <button type="submit" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="card card-body shadow">
  <div class="calendar" data-bs-toggle="calendar" id="calendar"></div>
</div>
@endsection

@section('footer')
<script src="{{ asset('vendor/fullcalendar/main.min.js') }}"></script>
<script src="{{ asset('vendor/daterangepicker/moment.min.js') }}"></script>

<script>
  var calendar = new FullCalendar.Calendar(document.getElementById("calendar"), {
    initialView: "dayGridMonth",
    headerToolbar: {
      start: 'title', // will normally be on the left. if RTL, will be on the right
      center: '',
      end: 'today prev,next' // will normally be on the right. if RTL, will be on the left
    },
    selectable: true,
    editable: true,
    events: {!! json_encode($agendas) !!},
    views: {
      month: {
        titleFormat: {
          month: "long",
          year: "numeric"
        }
      },
      agendaWeek: {
        titleFormat: {
          month: "long",
          year: "numeric",
          day: "numeric"
        }
      },
      agendaDay: {
        titleFormat: {
          month: "short",
          year: "numeric",
          day: "numeric"
        }
      }
    },

    eventClick(a, b, c) {
      $.ajax({
        url : '{{ route('agenda.api') }}',
        type: 'POST',
        data: {id: a.event.id},
        headers: {
          Accept: 'application/json',
          ContentType: 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },

        success(success) {
          $('#info-table #event_name').html(success.event_name);
          $('#info-table #event_start').html(moment(success.event_start).format('LLLL'));
          $('#info-table #description').html(success.description);
          $('#info-table #event_type').html(success.event_type.toUpperCase());
          $('#info-table #place').html(success.place.toUpperCase());
          $('#info-table #funded').html(success.funded == true ? 'Funded' : 'Not Funded');
          $('form#deleteEvent').attr('action', '{{ route("agenda.index") }}/' + success.id + '/delete');

          console.log('{{ route("agenda.index") }}/' + success.id + '/delete');

          if(success.event_type == 'online')
            $('.collapse#event_url_collapse').collapse('show')
            $('#info-table span#event_url').html(success.event_url);
            $('#info-table a#event_url').attr('href', success.event_url);

          $('#eventInfo').modal('show');
        },
        error(error) {
          Snackbar.show({
            pos: 'top-right',
            actionText: 'Close',
            width: '25%',
            text: 'Sorry, server has been trouble. Please try again later.',
            textColor: '#FFFFFF',
            backgroundColor: '#e74a3b',
            actionTextColor: '#FFFFFF',
          });
        },
      });
    }
  });

  calendar.render();
</script>
@endsection
