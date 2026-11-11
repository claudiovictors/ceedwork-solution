<?php

namespace App\Support;

use App\Rules\HexColor;
use App\Rules\ImageUrl;
use App\Rules\SafeUrl;
use Illuminate\Validation\Rule;

final class ContentSchema
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public static function settingsGroups(): array
    {
        return config('site_content.settings', []);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public static function settingsFields(string $group): array
    {
        return data_get(self::settingsGroups(), "{$group}.fields", []);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public static function pages(): array
    {
        return config('site_content.pages', []);
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function page(string $page): ?array
    {
        return data_get(self::pages(), $page);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public static function sections(string $page): array
    {
        return data_get(self::pages(), "{$page}.sections", []);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public static function sectionFields(string $page, string $section): array
    {
        return data_get(self::pages(), "{$page}.sections.{$section}.fields", []);
    }

    /**
     * Gera regras de validação para um conjunto simples de campos.
     *
     * @param  array<string, array<string, mixed>>  $fields
     * @return array<string, array<int, mixed>>
     */
    public static function rules(array $fields): array
    {
        $rules = [];

        foreach ($fields as $key => $field) {
            $rules[$key] = self::fieldRules($field);

            if (($field['type'] ?? null) === 'image') {
                $rules["{$key}_url"] = ['nullable', 'string', new ImageUrl];
            }

            if (($field['type'] ?? null) === 'repeater') {
                foreach (($field['fields'] ?? []) as $subKey => $subField) {
                    $rules["{$key}.*.{$subKey}"] = self::fieldRules($subField);
                }
            }
        }

        return $rules;
    }

    /**
     * Gera regras para todas as secções de uma página, com prefixo por secção.
     *
     * @return array<string, array<int, mixed>>
     */
    public static function pageRules(string $page): array
    {
        $rules = [];

        foreach (self::sections($page) as $sectionKey => $section) {
            foreach (($section['fields'] ?? []) as $fieldKey => $field) {
                $name = "{$sectionKey}_{$fieldKey}";
                $rules[$name] = self::fieldRules($field);

                if (($field['type'] ?? null) === 'image') {
                    $rules["{$name}_url"] = ['nullable', 'string', new ImageUrl];
                }

                if (($field['type'] ?? null) === 'repeater') {
                    foreach (($field['fields'] ?? []) as $subKey => $subField) {
                        $rules["{$name}.*.{$subKey}"] = self::fieldRules($subField);
                    }
                }
            }
        }

        return $rules;
    }

    /**
     * @param  array<string, array<string, mixed>>  $fields
     * @return array<string, string>
     */
    public static function attributes(array $fields): array
    {
        $attributes = [];

        foreach ($fields as $key => $field) {
            $attributes[$key] = $field['label'] ?? $key;

            if (($field['type'] ?? null) === 'image') {
                $attributes["{$key}_url"] = ($field['label'] ?? $key).' (URL)';
            }

            if (($field['type'] ?? null) === 'repeater') {
                foreach (($field['fields'] ?? []) as $subKey => $subField) {
                    $attributes["{$key}.*.{$subKey}"] = sprintf(
                        '%s (%s)',
                        $field['label'] ?? $key,
                        $subField['label'] ?? $subKey
                    );
                }
            }
        }

        return $attributes;
    }

    /**
     * @return array<string, string>
     */
    public static function pageAttributes(string $page): array
    {
        $attributes = [];

        foreach (self::sections($page) as $sectionKey => $section) {
            foreach (($section['fields'] ?? []) as $fieldKey => $field) {
                $name = "{$sectionKey}_{$fieldKey}";
                $attributes[$name] = $field['label'] ?? $fieldKey;

                if (($field['type'] ?? null) === 'image') {
                    $attributes["{$name}_url"] = ($field['label'] ?? $fieldKey).' (URL)';
                }

                if (($field['type'] ?? null) === 'repeater') {
                    foreach (($field['fields'] ?? []) as $subKey => $subField) {
                        $attributes["{$name}.*.{$subKey}"] = sprintf(
                            '%s (%s)',
                            $field['label'] ?? $fieldKey,
                            $subField['label'] ?? $subKey
                        );
                    }
                }
            }
        }

        return $attributes;
    }

    /**
     * @param  array<string, array<string, mixed>>  $fields
     * @return array<string, mixed>
     */
    public static function defaults(array $fields): array
    {
        $defaults = [];

        foreach ($fields as $key => $field) {
            $defaults[$key] = array_key_exists('default', $field) ? $field['default'] : null;
        }

        return $defaults;
    }

    /**
     * @param  array<string, mixed>  $field
     * @return array<int, mixed>
     */
    private static function fieldRules(array $field): array
    {
        return array_merge(
            $field['rules'] ?? ['nullable'],
            self::typeRules($field)
        );
    }

    /**
     * @param  array<string, mixed>  $field
     * @return array<int, mixed>
     */
    private static function typeRules(array $field): array
    {
        return match ($field['type'] ?? 'text') {
            'color' => [new HexColor],
            'url' => [new SafeUrl],
            'image' => ! empty($field['allow_ico'])
                ? ['file', 'mimes:ico,png,jpg,jpeg,webp', 'max:2048']
                : ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'select' => [Rule::in(array_keys($field['options'] ?? []))],
            'toggle' => ['boolean'],
            default => [],
        };
    }
}
