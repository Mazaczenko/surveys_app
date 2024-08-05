<?php

namespace App\Http\Requests;

use App\Rules\ValidateColorOptions;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StepThreeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'colorOptions' => ['required', 'array', new ValidateColorOptions],
            'colorOptions.*.value' => 'required|integer',
            'colorOptions.*.rate' => 'required|numeric|min:1|max:5',
            'step' => 'required|integer|between:1,3',
            'attempt_id' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'colorRatings.*.rate.required' => 'Each color rating is required.',
            'colorRatings.*.rate.numeric' => 'Each color rating must be a number between 1 and 5.',
        ];
    }
}
