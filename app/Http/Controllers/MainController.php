<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;

class MainController extends Controller
{
  /**
   * Initialize the class
   *
   * @package college-life
   * @since 1.0.0
   */
  public function __construct()
  {
    $this->middleware('auth.login');
  }

  /**
   * Show Main Page of Panel
   *
   * @package college-life
   * @since 1.0.0
   */
  public function index(Events $event, \Carbon\Carbon $carbon) {
    $start   = $carbon->now()->startOfWeek();
    $end     = $carbon->now()->endOfWeek();
    $summary = $event->whereBetween('start_time', [$start, $end]);

    $data['event_nearest'] = $summary->get()->take(5);
    $data['event_new']     = $summary->orderBy('created_at', 'ASC')->get()->take(10);
    $data['event_count']   = $event->get()->count();
    $data['title']         = 'Beranda Admin';

    // dd($data);

    return view('welcome', $data);
  }
}
