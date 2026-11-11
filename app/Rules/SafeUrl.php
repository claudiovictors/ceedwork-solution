<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SafeUrl implements ValidationRule
{
    /**
     * Valida ligações http(s), mailto, tel e caminhos relativos.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || preg_match('~^(https?://[^\s]+|mailto:[^\s]+|tel:[^\s]+|/(?!/)[^\s]*|#[^\s]*)$~i', $value) !== 1) {
            $fail('O campo :attribute deve conter uma ligação válida (https://, mailto:, tel: ou /caminho).');
        }
    }
}
