<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Team::class;

    public function definition(): array
    {
        return [
            'logo' => 'tmpLogo',
            'nazwa' => fake()->name(),
            'opis' =>  fake()->paragraph(),
            'leader_id' => fake()->unique()->numberBetween($min = 6, $max = 25)
        ];
    }
}
