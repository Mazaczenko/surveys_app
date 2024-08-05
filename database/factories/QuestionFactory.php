<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Survey;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
        return [
            'survey_id' => Survey::factory(),
            'question_text' => $this->faker->sentence,
            'question_type' => $this->faker->randomElement(['textarea', 'select', 'rating']),
        ];
    }
}
