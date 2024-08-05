<?php

namespace Database\Factories;

use App\Models\Attempt;
use App\Models\Survey;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class AttemptFactory extends Factory
{
    protected $model = Attempt::class;

    public function definition(): array
    {
        return [
            'survey_id' => Survey::factory(),
            'is_completed' => $this->faker->boolean(80),  // 80% chance of being true
        ];
    }
}
