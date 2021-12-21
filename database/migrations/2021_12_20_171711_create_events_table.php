<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('events', function (Blueprint $table) {
      $table->id();
      $table->timestamps();

      $table->string('event_name')->nullable();
      $table->string('event_creator')->nullable();
      $table->longText('event_pict')->nullable();
      $table->longText('event_url')->nullable();
      $table->string('author')->nullable();
      $table->longText('description')->nullable();
      $table->dateTime('start_time')->nullable()->useCurrent();
      $table->dateTime('end_time')->nullable()->useCurrent();
      $table->enum('place', ['online', 'local', 'outside'])->nullable();
      $table->boolean('funded')->nullable();
      $table->enum('event_type', ['scholarship', 'competition', 'volunteer', 'seminar'])->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('events');
  }
}
