<?php

namespace Database\Factories;

use App\Models\Option;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class OptionFactory extends Factory
{
    protected $model = Option::class;

    public function definition(): array
    {
        return [
            'question_id' => Question::factory(),
            'option_text' => $this->faker->word,
        ];
    }

    // Create options specifically for select-type questions with Polish color names
    public function selectOptions(Question $question): OptionFactory
    {
        $colors = ['czerwony', 'żółty', 'pomarańczowy', 'zielony', 'niebieski', 'fioletowy'];

        return $this->state(function () use ($question, $colors) {
            return [
                'question_id' => $question->id,
                'option_text' => $this->faker->randomElement($colors),
            ];
        });
    }

    // Create numeric options for rating-type questions, if needed
    public function numericOptions(Question $question): OptionFactory
    {
        return $this->state(function () use ($question) {
            return [
                'question_id' => $question->id,
                'option_text' => null,
            ];
        });
    }
}
