<?php

namespace Database\Factories;

use App\Models\Institution;
use App\Models\Mentor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Participant>
 */
class ParticipantFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $mentor = Mentor::inRandomOrder()->first();
    $institution = Institution::inRandomOrder()->first();
    $user = User::factory()->create([
      'role' => 'Participant',
    ]);

    return [
      'phone' => $this->faker->numerify('+62 888 #### ####'),
      'position' => 'Mahasiswa',
      'user_id' => $user->id,
      'mentor_id' => $mentor->id,
      'institution_id' => $institution->id,
    ];
  }
}
