<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Events;

class EventController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data['events'] = Events::paginate();
    $data['count']  = Events::get()->count();
    return view('user.event-index', $data);
  }

  public function process($id)
  {
    $search = Events::find($id);
    if(!$search) return redirect()->back()->with('error', 'Event is not found on database, aborted!');

    $agenda = new Agenda();
    $get    = $search->first();
    $agenda->create([
      'event_id' => $get->id,
      'type'     => 'event',
      'label'    => 'info',
      'user_id'  => auth()->guard('user')->user()->id,
    ]);

    return redirect()->route('event.index')->with('success', 'Success to adding event to your agenda!');
  }

  public function register($id)
  {
    $search = Events::find($id);
    if(!$search) return redirect()->route('event.index')->with('error', 'Event is not found on database, aborted!');

    $data['event'] = $search;
    return view('user.event-register', $data);
  }

  function seminar()
  {
    $data['events'] = Events::where('event_type', 'seminar')->paginate();
    $data['count']  = Events::where('event_type', 'seminar')->count();
    return view('user.event-index', $data);
  }

  function competition()
  {
    $data['events'] = Events::where('event_type', 'competition')->paginate();
    $data['count']  = Events::where('event_type', 'competition')->count();
    return view('user.event-index', $data);
  }

  function volunteer()
  {
    $data['events'] = Events::where('event_type', 'volunteer')->paginate();
    $data['count']  = Events::where('event_type', 'volunteer')->count();
    return view('user.event-index', $data);
  }

  function scholarship()
  {
    $data['events'] = Events::where('event_type', 'scholarship')->paginate();
    $data['count']  = Events::where('event_type', 'scholarship')->count();
    return view('user.event-index', $data);
  }
}
