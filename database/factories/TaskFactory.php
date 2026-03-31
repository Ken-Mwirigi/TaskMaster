<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;


 // @extends Factory<Task>
 
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'title' => $this->faker->sentence(3),
        'due_date' => now()->addDays(rand(1, 10))->toDateString(), // Generates a valid future date
        'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
        'status' => 'pending', // Default status
    ];
}
}
