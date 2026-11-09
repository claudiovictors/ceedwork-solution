<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

final class ImageUploader
{
    /**
     * Store an uploaded image on the public disk.
     */
    public function store(UploadedFile $file, string $directory): string
    {
        $extension = $file->extension() ?: $file->guessExtension() ?: 'jpg';
        $path = $file->storeAs(
            trim($directory, '/'),
            Str::uuid()->toString().'.'.$extension,
            'public'
        );

        if (! is_string($path)) {
            throw new RuntimeException('Não foi possível guardar a imagem.');
        }

        return $path;
    }

    /**
     * Store an image uploaded through the rich text editor.
     */
    public function storeEditorImage(UploadedFile $file): string
    {
        return $this->store($file, 'posts/content/'.now()->format('Y/m'));
    }

    /**
     * Delete a previously stored image, ignoring external and bundled assets.
     */
    public function delete(?string $path): void
    {
        if (blank($path)) {
            return;
        }

        if (Str::startsWith($path, [
            'http://',
            'https://',
            '//',
            'assets/',
            '/assets/',
            '/storage/',
        ])) {
            return;
        }

        Storage::disk('public')->delete($path);
    }
}
