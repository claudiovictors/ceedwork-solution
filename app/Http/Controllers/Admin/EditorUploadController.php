<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\ImageUploader;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EditorUploadController extends Controller
{
    public function __construct(
        private readonly ImageUploader $uploader,
    ) {}

    /**
     * Guarda uma imagem inserida no editor de conteúdo.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate(
            [
                'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            ],
            [
                'image.required' => 'Selecione uma imagem.',
                'image.image' => 'O ficheiro deve ser uma imagem.',
                'image.mimes' => 'A imagem deve ser JPG, PNG ou WebP.',
                'image.max' => 'A imagem não pode exceder 2 MB.',
            ],
            [
                'image' => 'imagem',
            ]
        );

        $path = $this->uploader->storeEditorImage($validated['image']);

        return response()->json([
            'url' => Storage::disk('public')->url($path),
        ]);
    }
}
