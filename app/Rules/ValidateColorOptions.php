<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateColorOptions implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if $value is an array
        if (!is_array($value)) {
            $fail('The :attribute must be an array.');
            return;
        }

        // Check if any item in the array has a null 'rate' value
        foreach ($value as $item) {
            if (isset($item['rate']) && $item['rate'] === null) {
                $fail('All color options must have a rating.');
                return;
            }
        }
    }
}
