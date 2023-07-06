<?php

namespace Database\Factories;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
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
            'title'  => $this->faker->sentence,
            'description' =>  $this->faker->text(500),
            'project_id' => Project::get()->random()->id,
            'begin_time' => Carbon::now(),
            'stop_time' => Carbon::now()->addMinutes(rand(5,3000)),
        ];
    }
}
