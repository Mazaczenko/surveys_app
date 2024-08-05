<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Attempt;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class AnswerFactory extends Factory
{
    protected $model = Answer::class;

    public function definition(): array
    {
        return [
            'question_id' => Question::factory(),
            'attempt_id' => Attempt::factory(),
            'text' => $this->faker->paragraph,
            'numeric' => null,
            'option_id' => null,
            'type' => 'text',
        ];
    }

    public function textareaAnswer(Question $question, Attempt $attempt): AnswerFactory
    {
        return $this->state(function () use ($question, $attempt) {
            return [
                'question_id' => $question->id,
                'attempt_id' => $attempt->id,
                'text' => $this->faker->sentence,
                'numeric' => null,
                'option_id' => null,
                'type' => 'text',
            ];
        });
    }

    public function selectAnswer(Question $question, Attempt $attempt): AnswerFactory
    {
        $option = Option::where('question_id', $question->id)->inRandomOrder()->first();

        return $this->state(function () use ($question, $attempt, $option) {
            return [
                'question_id' => $question->id,
                'attempt_id' => $attempt->id,
                'text' => null,
                'numeric' => null,
                'option_id' => $option->id,
                'type' => 'option',
            ];
        });
    }

    public function ratingAnswer(Question $question, Attempt $attempt): AnswerFactory
    {
        return $this->state(function () use ($question, $attempt) {
            return [
                'question_id' => $question->id,
                'attempt_id' => $attempt->id,
                'text' => null,
                'numeric' => $this->faker->numberBetween(1, 5),
                'option_id' => null,
                'type' => 'numeric',
            ];
        });
    }
}
