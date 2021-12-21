<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
  use HasFactory;

  protected $guarded = [];

  function event()
  {
    return $this->belongsTo(Events::class, 'event_id', 'id');
  }
}
