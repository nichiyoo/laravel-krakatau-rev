<?php

namespace Database\Factories;

use App\Models\Division;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mentor>
 */
class MentorFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $division = Division::inRandomOrder()->first();
    $user = User::factory()->create([
      'role' => 'Mentor',
    ]);

    return [
      'phone' => $this->faker->numerify('+62 888 #### ####'),
      'division_id' => $division->id,
      'user_id' => $user->id,
    ];
  }
}
