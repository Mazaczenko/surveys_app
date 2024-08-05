<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Attempt;
use App\Models\Option;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttemptSeeder extends Seeder
{
    public function run()
    {
        // Get the survey ID (assuming only one survey exists)
        $surveyId = Survey::first()->id;

        // Create 100 attempts
        foreach (range(1, 100) as $index) {
            $attempt = Attempt::factory()->create([
                'survey_id' => $surveyId,
                'user_id' => null, // Set this to a user ID if necessary
                'is_completed' => true
            ]);

            // Get all questions for this survey
            $questions = Question::where('survey_id', $surveyId)->get();

            foreach ($questions as $question) {
                switch ($question->question_type) {
                    case 'textarea':
                        Answer::factory()->textareaAnswer($question, $attempt)->create();
                        break;

                    case 'select':
                        $option = Option::where('question_id', $question->id)->inRandomOrder()->first();
                        Answer::factory()->selectAnswer($question, $attempt)->create([
                            'option_id' => $option->id,
                            'answer_text' => null,
                            'answer_numeric' => null
                        ]);
                        break;

                    case 'rating':
                        Answer::factory()->ratingAnswer($question, $attempt)->create();
                        break;
                }
            }
        }
    }
}
