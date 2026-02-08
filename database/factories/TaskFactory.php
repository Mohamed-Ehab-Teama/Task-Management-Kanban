<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = \App\Models\Task::class;

    public function definition()
    {
        $priorities = ['Low', 'Medium', 'High', 'Urgent'];
        return [
            'board_id' => \App\Models\Board::factory(),
            'column_id' => \App\Models\BoardColumn::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'priority' => $this->faker->randomElement($priorities),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'estimate_minutes' => $this->faker->numberBetween(30, 300),
            'actual_minutes' => $this->faker->numberBetween(30, 300),
            'position' => $this->faker->numberBetween(1, 10),
            'is_archived' => false,
            'created_by' => \App\Models\User::factory(),
        ];
    }
}
