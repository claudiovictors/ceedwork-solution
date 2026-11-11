<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HexColor implements ValidationRule
{
    /**
     * Valida uma cor hexadecimal no formato #RRGGBB.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || preg_match('/^#[0-9a-fA-F]{6}$/', $value) !== 1) {
            $fail('O campo :attribute deve ser uma cor hexadecimal válida (ex.: #13397c).');
        }
    }
}
