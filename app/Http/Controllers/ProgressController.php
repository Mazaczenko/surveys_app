<?php

namespace App\Http\Controllers;

use App\Http\Requests\StepOneRequest;
use App\Http\Requests\StepThreeRequest;
use App\Http\Requests\StepTwoRequest;
use App\Models\Answer;
use App\Models\Attempt;
use App\Models\Survey;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class ProgressController extends Controller
{
    /**
     * Handle the progress storage.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function store(Request $request): \Inertia\Response | RedirectResponse
    {
        $validated = $this->validateStepData($request);

        $this->processStepData($validated);

        $survey = Survey::query()->with('questions.options')->get()->first();

        return Inertia::render('Attempts/Create', [
            'status' => 'Progress saved successfully',
            'survey' => $survey,
        ]);
    }

    /**
     * Validate request data based on the step.
     *
     * @param Request $request
     * @return array
     */
    private function validateStepData(Request $request): array
    {
        $step = $request->input('step');

        $validationRules = $this->getValidationRulesForStep($step);

        if (!$validationRules) {
            abort(400, 'Invalid step');
        }

        return $request->validate($validationRules);
    }

    /**
     * Get validation rules based on the step.
     *
     * @param int $step
     * @return array|null
     */
    private function getValidationRulesForStep(int $step): ?array
    {
        return match ($step) {
            1 => (new StepOneRequest())->rules(),
            2 => (new StepTwoRequest())->rules(),
            3 => (new StepThreeRequest())->rules(),
            default => null,
        };
    }

    /**
     * Process validated data based on the step.
     *
     * @param array $validated
     * @return void
     */
    private function processStepData(array $validated): void
    {
        $step = $validated['step'];

        match ($step) {
            1 => $this->processStepOneData($validated),
            2 => $this->processStepTwoData($validated),
            3 => $this->processStepThreeData($validated),
        };
    }

    /**
     * Process data for step 1.
     *
     * @param array $validated
     * @return void
     */
    private function processStepOneData(array $validated): void
    {
        Answer::updateOrCreate(
            [
                'attempt_id' => $validated['attempt_id'],
                'question_id' => $validated['step'],
            ],
            [
                'text' => $validated['sources'],
                'type' => 'text',
            ]
        );
    }

    /**
     * Process data for step 2.
     *
     * @param array $validated
     * @return void
     */
    private function processStepTwoData(array $validated): void
    {
        Answer::updateOrCreate(
            [
                'attempt_id' => $validated['attempt_id'],
                'question_id' => $validated['step'],
            ],
            [
                'option_id' => $validated['color'],
                'type' => 'option',
            ]
        );
    }

    /**
     * Process data for step 3.
     *
     * @param array $validated
     * @return void
     */
    private function processStepThreeData(array $validated): void
    {
        $attemptId = $validated['attempt_id'];

        // Update or create Answer records
        foreach ($validated['colorOptions'] as $answer) {
            Answer::updateOrCreate(
                [
                    'attempt_id' => $attemptId,
                    'question_id' => $validated['step'],
                    'option_id' => $answer['value'],
                ],
                [
                    'numeric' => $answer['rate'],
                    'type' => 'numeric',
                ]
            );
        }

        Attempt::find($attemptId)->update(['is_completed' => true]);
    }
}
