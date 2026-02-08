<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BoardFactory extends Factory
{
    protected $model = \App\Models\Board::class;

    public function definition()
    {
        return [
            'team_id' => \App\Models\Team::factory(),
            'name' => $this->faker->catchPhrase,
            'description' => $this->faker->sentence,
            'is_archived' => false,
        ];
    }
}
