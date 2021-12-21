<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendasTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('agendas', function (Blueprint $table) {
      $table->id();
      $table->timestamps();

      $table->string('user_id')->nullable();
      $table->enum('type', ['event', 'myagenda'])->nullable();
      $table->enum('label', ['primary', 'secondary', 'success', 'danger', 'warning', 'info'])->nullable()->default('primary');
      $table->string('event_id')->nullable();
      $table->string('event_name')->nullable();
      $table->dateTime('event_start')->nullable();
      $table->string('event_description')->nullable();
      $table->string('reminder_on')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('agendas');
  }
}
