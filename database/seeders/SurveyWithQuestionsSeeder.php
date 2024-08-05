<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SurveyWithQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create the survey
        $survey = Survey::create([
            'title' => 'Kolorowa Ankieta',
            'description' => 'Odpowiedz na pytania różnych typów.',
        ]);

        // Create the first question (textarea)
        Question::create([
            'survey_id' => $survey->id,
            'value' => 'Z jakich źródeł korzystasz tworząc paletę kolorów?',
            'type' => 'textarea',
        ]);

        // Create the second question (select)
        $question2 = Question::create([
            'survey_id' => $survey->id,
            'value' => 'Twój ulubiony kolor',
            'type' => 'select',
        ]);

        // Create options for the second question
        $colors = ['czerwony', 'żółty', 'pomarańczowy', 'zielony', 'niebieski', 'fioletowy'];
        foreach ($colors as $color) {
            Option::create([
                'question_id' => $question2->id,
                'value' => $color,
            ]);
        }

        // Create the third question (rating)
         Question::create([
            'survey_id' => $survey->id,
            'value' => 'Oceń kolory',
            'type' => 'rating',
        ]);
    }
}
