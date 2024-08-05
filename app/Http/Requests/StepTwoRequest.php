<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StepTwoRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'color' => 'required|integer',
            'step' => 'required|integer|between:1,3',
            'attempt_id' => 'required|integer'
        ];
    }
}
