<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class ImageUrl
{
    /**
     * Resolve a public URL for a stored image path.
     */
    public static function for(?string $value, ?string $fallback = null): string
    {
        $fallback ??= asset('assets/images/core/logo_icon.png');

        if (blank($value)) {
            return $fallback;
        }

        if (Str::startsWith($value, ['http://', 'https://', '//'])) {
            return $value;
        }

        if (Str::startsWith($value, ['assets/', '/assets/'])) {
            return asset(ltrim($value, '/'));
        }

        if (Str::startsWith($value, '/storage/')) {
            return $value;
        }

        return Storage::disk('public')->url($value);
    }
}
