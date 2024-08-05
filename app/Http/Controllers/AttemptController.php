<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use App\Models\Survey;
use Inertia\Inertia;
use Inertia\Response;

class AttemptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Attempts/Index', [
            'attempts' => Attempt::list(),
            'survey' => Survey::list()
         ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $survey = Survey::query()->with('questions.options')->get()->first();

        return Inertia::render('Attempts/Create', [
            'attempt' => Attempt::create([
                'survey_id' => $survey->id
            ]),
            'survey' => $survey
        ]);
    }
}
