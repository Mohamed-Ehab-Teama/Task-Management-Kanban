<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ColumnFactory extends Factory
{
    protected $model = \App\Models\BoardColumn::class;

    public function definition()
    {
        return [
            'board_id' => \App\Models\Board::factory(),
            'name' => $this->faker->word,
            'position' => $this->faker->numberBetween(1, 5),
            'wip_limit' => $this->faker->numberBetween(1, 10),
        ];
    }
}
