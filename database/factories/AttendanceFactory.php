<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'start' => Carbon::now()->subMonth(2),
      'end' => Carbon::now()->addMonth(1),
      'status' => 'Ongoing',
      'hours' => $this->faker->numberBetween(1, 10),
      'days' => $this->faker->numberBetween(1, 10),
      'presences' => $this->faker->numberBetween(1, 10),
    ];
  }
}
