<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
  use HasFactory;

  protected $guarded = [];

  public function agenda()
  {
    return $this->hasMany(Agenda::class, 'event_id', 'id');
  }

  public function author()
  {
    return $this->belongsTo(User::class, 'author', 'id');
  }

  public static function boot()
  {
    parent::boot();

    self::deleting(function($event) {
      $event->agenda()->each(function($agenda) {
        $agenda->delete();
      });
    });
  }
}
