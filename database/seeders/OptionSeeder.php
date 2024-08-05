<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Question;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    public function run()
    {
        // Fetch all select-type questions
        $selectQuestions = Question::where('question_type', 'select')->get();

        foreach ($selectQuestions as $question) {
            // Create multiple options for each select question with Polish colors
            Option::factory()->count(6)->selectOptions($question)->create();
        }

        // Optionally handle rating-type questions if you want to seed numeric options in a different way
        $ratingQuestions = Question::where('question_type', 'rating')->get();

        foreach ($ratingQuestions as $question) {
            for ($i = 1; $i <= 5; $i++) {
                Option::factory()->numericOptions($question)->create([
                    'option_text' => $i,
                ]);
            }
        }
    }
}
