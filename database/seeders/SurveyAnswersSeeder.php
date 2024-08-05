<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Attempt;
use App\Models\Option;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SurveyAnswersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();
        $survey = Survey::first(); // Assuming only one survey for simplicity
        $questions = Question::where('survey_id', $survey->id)->get();

        $selectQuestion = $questions->where('type', 'select')->first();
        $ratingQuestion = $questions->where('type', 'rating')->first();
        $selectOptions = Option::where('question_id', $selectQuestion->id)->get();

        for ($i = 0; $i < 100; $i++) {

            $attempt = Attempt::create([
               'survey_id' =>$survey->id,
               'is_completed' => 1
            ]);

            // Answer for textarea question
            Answer::create([
                'attempt_id' => $attempt->id,
                'question_id' => $questions->where('type', 'textarea')->first()->id,
                'text' => $faker->paragraph,
                'type' => 'text',
            ]);

            // Answer for select question
            $selectedOption = $selectOptions->random();
            Answer::create([
                'attempt_id' => $attempt->id,
                'question_id' => $selectQuestion->id,
                'option_id' => $selectedOption->id, // Store the ID of the selected option
                'type' => 'option',
            ]);

            // Answer for rating question
            foreach ($selectOptions as $key => $option) {
                Answer::create([
                    'attempt_id' => $attempt->id,
                    'question_id' => $ratingQuestion->id,
                    'option_id' => $key + 1,
                    'numeric' => rand(1, 5), // Store the rating value
                    'type' => 'numeric',
                ]);
            }
        }
    }
}
