<?php

namespace App\Http\Requests\Admin;

use App\Models\Service;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreServiceRequest extends FormRequest
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

        $items = collect($this->input('items', []))
            ->map(fn (mixed $item): mixed => is_string($item) ? trim($item) : $item)
            ->filter(fn (mixed $item): bool => filled($item))
            ->values()
            ->all();

        $this->merge([
            'slug' => Str::slug($slug !== '' ? $slug : $title),
            'items' => $items,
            'is_active' => $this->boolean('is_active'),
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
        $uniqueSlug = Rule::unique('services', 'slug');

        if ($service = $this->route('service')) {
            $uniqueSlug->ignore($service instanceof Service ? $service->getKey() : $service);
        }

        return [
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['required', 'string', 'max:200', $uniqueSlug],
            'icon' => ['nullable', 'string', 'max:120'],
            'summary' => ['required', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_image' => ['boolean'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'items' => ['required', 'array', 'min:1'],
            'items.*' => ['required', 'string', 'max:160'],
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
            'title.required' => 'Indique o título do serviço.',
            'title.max' => 'O título não pode exceder 180 caracteres.',
            'slug.required' => 'Indique o slug do serviço.',
            'slug.unique' => 'Já existe um serviço com este slug.',
            'summary.required' => 'Escreva o resumo do serviço.',
            'summary.max' => 'O resumo não pode exceder 1000 caracteres.',
            'image.image' => 'O ficheiro deve ser uma imagem.',
            'image.mimes' => 'A imagem deve ser JPG, PNG ou WebP.',
            'image.max' => 'A imagem não pode exceder 4 MB.',
            'sort_order.integer' => 'A ordem deve ser um número inteiro.',
            'sort_order.min' => 'A ordem não pode ser negativa.',
            'items.required' => 'Adicione pelo menos um item ao serviço.',
            'items.min' => 'Adicione pelo menos um item ao serviço.',
            'items.*.required' => 'Preencha ou remova os itens vazios.',
            'items.*.max' => 'Cada item não pode exceder 160 caracteres.',
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
            'icon' => 'ícone',
            'summary' => 'resumo',
            'image' => 'imagem',
            'sort_order' => 'ordem',
            'items' => 'itens',
            'items.*' => 'item',
        ];
    }
}
