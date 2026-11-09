<?php

namespace App\Http\Requests\Admin;

use App\Enums\PostStatus;
use App\Models\Post;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $title = (string) $this->input('title', '');
        $slug = (string) $this->input('slug', '');

        $this->merge([
            'slug' => Str::slug($slug !== '' ? $slug : $title),
            'is_featured' => $this->boolean('is_featured'),
            'remove_cover' => $this->boolean('remove_cover'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $uniqueSlug = Rule::unique('posts', 'slug');

        if ($post = $this->route('post')) {
            $uniqueSlug->ignore($post instanceof Post ? $post->getKey() : $post);
        }

        return [
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['required', 'string', 'max:200', $uniqueSlug],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_cover' => ['boolean'],
            'status' => ['required', Rule::enum(PostStatus::class)],
            'is_featured' => ['boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Indique o título da notícia.',
            'title.max' => 'O título não pode exceder 180 caracteres.',
            'slug.required' => 'Indique o slug da notícia.',
            'slug.max' => 'O slug não pode exceder 200 caracteres.',
            'slug.unique' => 'Já existe uma notícia com este slug.',
            'category_id.required' => 'Selecione uma categoria.',
            'category_id.exists' => 'A categoria selecionada não existe.',
            'excerpt.max' => 'O resumo não pode exceder 500 caracteres.',
            'body.required' => 'Escreva o conteúdo da notícia.',
            'cover_image.image' => 'O ficheiro deve ser uma imagem.',
            'cover_image.mimes' => 'A imagem deve ser JPG, PNG ou WebP.',
            'cover_image.max' => 'A imagem não pode exceder 4 MB.',
            'status.required' => 'Selecione o estado da notícia.',
            'status.enum' => 'O estado selecionado não é válido.',
            'published_at.date' => 'A data de publicação não é válida.',
        ];
    }

    /**
     * Get custom attribute names.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'título',
            'slug' => 'slug',
            'category_id' => 'categoria',
            'excerpt' => 'resumo',
            'body' => 'conteúdo',
            'cover_image' => 'imagem de capa',
            'status' => 'estado',
            'published_at' => 'data de publicação',
            'is_featured' => 'destaque',
        ];
    }
}
