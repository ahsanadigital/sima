<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Events;
use Illuminate\Http\Request;

class AgendaController extends Controller
{

  public function api(Events $event, Request $request)
  {
    $id = htmlspecialchars(strip_tags($request->id));
    $check = $event->find($id);

    if($check)
      return response($check->first()->toArray());
    else
      return response($event->all());
  }

  function delete($id, Agenda $agenda)
  {
    $check = $agenda->find($id);

    if($check) :
      $check->delete();
      return redirect()->route('agenda.index')->with('success', 'Successfuly delete agenda!');
    else :
      return redirect()->route('agenda.index')->with('error', 'We can\'t delete agenda!');
    endif;
  }

  public function index(Agenda $agenda)
  {
    $agendas        = $agenda->all();
    $data['agendas'] = [];

    foreach($agendas as $index => $agenda)
    {
      if($agenda->event()->count() > 0)
      {
        $event = $agenda->event()->first();
        $data['agendas'][$index]['id']        = $event->id;
        $data['agendas'][$index]['title']     = $event->event_name;
        $data['agendas'][$index]['start']     = $event->start_time;
        $data['agendas'][$index]['type']      = $agenda->type;
        $data['agendas'][$index]['className'] = "bg-{$agenda->label} text-white";
      } else {
        $data['agendas'][$index]['id']        = $agenda->id;
        $data['agendas'][$index]['title']     = $agenda->event_name;
        $data['agendas'][$index]['start']     = $agenda->event_start;
        $data['agendas'][$index]['type']      = $agenda->type;
        $data['agendas'][$index]['className'] = "bg-{$agenda->label} text-white";
      }
    }

    return view('user.agenda-index', $data);
  }
}
