<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Events;
use Illuminate\Http\Request;

class EventsController extends Controller
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
    return view('admin.events-index', $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('admin.events-create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $data['event_name']     = htmlspecialchars(strip_tags($request->event_name));
    $data['event_type']     = htmlspecialchars(strip_tags($request->event_type));
    $data['event_creator']  = htmlspecialchars(strip_tags($request->event_creator));
    $data['event_url']      = htmlspecialchars(strip_tags($request->event_url));
    $data['description']    = htmlspecialchars($request->description);
    $data['place']          = htmlspecialchars($request->place);
    $data['funded']         = (bool) htmlspecialchars($request->funded);
    $data['author']         = auth()->guard('admin')->user()->id;

    if($request->event_pict) {
      $p    = $request->event_pict;
      $name = uniqid('upload-') . '.' . $p->getClientOriginalExtension();
      $path = 'images/upload';
      $p->move(public_path($path), $name);

      $pict = "{$path}/$name";
      $data['event_pict'] = $pict;
    }

    $date               = htmlspecialchars(strip_tags($request->date));
    $crack              = explode(' - ', $date);
    $data['start_time'] = \Carbon\Carbon::parse($crack[0])->format('Y-m-d H:i:s');
    $data['end_time']   = \Carbon\Carbon::parse($crack[1])->format('Y-m-d H:i:s');

    try {
      $event = Events::create($data);
      return redirect()->route('events.index')->with('success', 'Successfuly adding event.');
    } catch(\Exception $e) {
      return redirect()->route('events.index')->with('error', 'Sorry, server has been trouble for now. Try again a few time!');
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $event = Events::find($id);
    if(!$event) return redirect()->route('events.index')->with('error', 'Event is not found on database, aborted!');

    $data['events'] = $event->first();
    return view('admin.events-show', $data);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $event = Events::find($id);
    if(!$event) return redirect()->route('events.index')->with('error', 'Event is not found on database, aborted!');

    $data['events'] = $event->first();
    return view('admin.events-edit', $data);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $data['event_name']     = htmlspecialchars(strip_tags($request->event_name));
    $data['event_type']     = htmlspecialchars(strip_tags($request->event_type));
    $data['event_creator']  = htmlspecialchars(strip_tags($request->event_creator));
    $data['event_url']      = htmlspecialchars(strip_tags($request->event_url));
    $data['description']    = htmlspecialchars($request->description);
    $data['place']          = htmlspecialchars($request->place);
    $data['funded']         = (bool) htmlspecialchars($request->funded);

    if($request->event_pict) {
      $p    = $request->event_pict;
      $name = uniqid('upload-') . '.' . $p->getClientOriginalExtension();
      $path = 'images/upload';
      $p->move(public_path($path), $name);

      $pict = "{$path}/$name";
      $data['event_pict'] = $pict;
    }

    $date               = htmlspecialchars(strip_tags($request->date));
    $crack              = explode(' - ', $date);
    $data['start_time'] = \Carbon\Carbon::parse($crack[0])->format('Y-m-d H:i:s');
    $data['end_time']   = \Carbon\Carbon::parse($crack[1])->format('Y-m-d H:i:s');

    try {
      $event = Events::find($id)->update($data);
      return redirect()->route('events.index')->with('success', 'Successfuly updating event.');
    } catch(\Exception $e) {
      return redirect()->route('events.index')->with('error', 'Sorry, server has been trouble for now. Try again a few time!');
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $event = Events::find($id);
    if(!$event)
      return redirect()->route('events.index')->with('error', 'Event is not found on database, aborted!');
    else
      $event->delete();
      return redirect()->route('events.index')->with('success', 'Event successfully deleted!');
  }
}
