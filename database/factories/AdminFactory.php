<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    if(!file_exists('public/storage/images'))
      File::makeDirectory('public/storage/images', 666, true);

    return [
      'username'          => $this->faker->userName(),
      'fullname'          => $this->faker->name(),
      'email'             => $this->faker->unique()->safeEmail(),
      'email_verified_at' => now(),
      'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
      'pp'                => Str::replace([public_path('\\'), 'images\\'], ['', 'images/'], $this->faker->image(public_path('storage/images'), 640, 640, null, true)),
    ];
  }
}
