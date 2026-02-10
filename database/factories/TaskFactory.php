<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'status' => 'pending',
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'tenant_id' => Tenant::factory(),
            'created_by' => User::factory(), 
            'assigned_to' => null,
        ];
    }
}