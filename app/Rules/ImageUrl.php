<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ImageUrl implements ValidationRule
{
    /**
     * Valida URLs de imagem e caminhos locais de imagens.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || preg_match('~^(https?://[^\s]+|/(?!/)[^\s]*|assets/[^\s]+|storage/[^\s]+)$~i', $value) !== 1) {
            $fail('O campo :attribute deve conter um URL de imagem válido (https://, /caminho ou assets/...).');
        }
    }
}
