<?php

namespace App\Http\Requests\Admin;

use App\Models\Project;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
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
        $name = (string) $this->input('name', '');
        $slug = (string) $this->input('slug', '');
        $technologies = $this->input('technologies');

        if (is_string($technologies)) {
            $technologies = explode(',', $technologies);
        }

        if (! is_array($technologies)) {
            $technologies = [];
        }

        $technologies = collect($technologies)
            ->map(fn (mixed $technology): mixed => is_string($technology) ? trim($technology) : $technology)
            ->filter(fn (mixed $technology): bool => filled($technology))
            ->unique()
            ->values()
            ->all();

        $this->merge([
            'slug' => Str::slug($slug !== '' ? $slug : $name),
            'technologies' => $technologies,
            'is_published' => $this->boolean('is_published'),
            'remove_logo' => $this->boolean('remove_logo'),
            'remove_image' => $this->boolean('remove_image'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $uniqueSlug = Rule::unique('projects', 'slug');

        if ($project = $this->route('project')) {
            $uniqueSlug->ignore($project instanceof Project ? $project->getKey() : $project);
        }

        return [
            'name' => ['required', 'string', 'max:180'],
            'slug' => ['required', 'string', 'max:200', $uniqueSlug],
            'category' => ['nullable', 'string', 'max:100'],
            'summary' => ['required', 'string', 'max:1000'],
            'description' => ['nullable', 'string', 'max:20000'],
            'url' => ['nullable', 'url', 'max:2048'],
            'technologies' => ['nullable', 'array'],
            'technologies.*' => ['string', 'max:40'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_logo' => ['boolean'],
            'remove_image' => ['boolean'],
            'is_published' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
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
            'name.required' => 'Indique o nome do projeto.',
            'name.max' => 'O nome não pode exceder 180 caracteres.',
            'slug.required' => 'Indique o slug do projeto.',
            'slug.unique' => 'Já existe um projeto com este slug.',
            'summary.required' => 'Escreva o resumo do projeto.',
            'summary.max' => 'O resumo não pode exceder 1000 caracteres.',
            'description.max' => 'A descrição não pode exceder 20000 caracteres.',
            'url.url' => 'Indique um endereço válido, começando por http:// ou https://.',
            'technologies.*.max' => 'Cada tecnologia não pode exceder 40 caracteres.',
            'logo.image' => 'O logótipo deve ser uma imagem.',
            'logo.mimes' => 'O logótipo deve ser JPG, PNG ou WebP.',
            'logo.max' => 'O logótipo não pode exceder 4 MB.',
            'image.image' => 'A imagem deve ser uma imagem.',
            'image.mimes' => 'A imagem deve ser JPG, PNG ou WebP.',
            'image.max' => 'A imagem não pode exceder 4 MB.',
            'sort_order.integer' => 'A ordem deve ser um número inteiro.',
            'sort_order.min' => 'A ordem não pode ser negativa.',
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
            'name' => 'nome',
            'slug' => 'slug',
            'category' => 'categoria',
            'summary' => 'resumo',
            'description' => 'descrição',
            'url' => 'ligação',
            'technologies' => 'tecnologias',
            'technologies.*' => 'tecnologia',
            'logo' => 'logótipo',
            'image' => 'imagem',
            'sort_order' => 'ordem',
        ];
    }
}
