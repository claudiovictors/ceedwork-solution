<?php

namespace App\Support;

use Illuminate\Http\Request;

final class ContentFormProcessor
{
    public function __construct(
        private readonly ImageUploader $uploader,
        private readonly HtmlSanitizer $sanitizer,
    ) {}

    /**
     * Normaliza os valores de um formulário antes de os guardar.
     *
     * @param  array<string, array<string, mixed>>  $fields
     * @param  array<string, mixed>  $validated
     * @param  array<string, mixed>  $existing
     * @return array<string, mixed>
     */
    public function process(
        array $fields,
        array $validated,
        array $existing,
        string $directory,
        Request $request,
        string $namePrefix = '',
    ): array {
        $data = [];

        foreach ($fields as $key => $field) {
            $name = $namePrefix.$key;
            $type = $field['type'] ?? 'text';
            $current = array_key_exists($key, $existing)
                ? $existing[$key]
                : ($field['default'] ?? null);

            $data[$key] = match ($type) {
                'image' => $this->processImage($current, $directory, $name, $request),
                'toggle' => $request->boolean($name),
                'repeater' => $this->processRepeater($field, $validated[$key] ?? []),
                'rich' => $this->sanitizer->clean(
                    is_string($validated[$key] ?? $current) ? ($validated[$key] ?? $current) : null
                ),
                default => $validated[$key] ?? $current,
            };
        }

        return $data;
    }

    private function processImage(
        mixed $current,
        string $directory,
        string $name,
        Request $request,
    ): ?string {
        $current = is_string($current) ? $current : null;

        if ($request->hasFile($name)) {
            $this->uploader->delete($current);

            return $this->uploader->store($request->file($name), trim($directory, '/'));
        }

        if ($request->boolean("remove_{$name}")) {
            $this->uploader->delete($current);

            return null;
        }

        return $current;
    }

    /**
     * @param  array<string, mixed>  $field
     * @param  array<int, mixed>  $rows
     * @return array<int, array<string, mixed>>
     */
    private function processRepeater(array $field, array $rows): array
    {
        $result = [];

        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $processed = [];
            $isBlank = true;

            foreach (($field['fields'] ?? []) as $subKey => $subField) {
                $value = $row[$subKey] ?? null;

                if (($subField['type'] ?? null) === 'rich') {
                    $value = $this->sanitizer->clean(is_string($value) ? $value : null);
                }

                if (($subField['type'] ?? null) === 'toggle') {
                    $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                }

                $processed[$subKey] = $value;

                if (! blank($value)) {
                    $isBlank = false;
                }
            }

            if (! $isBlank) {
                $result[] = $processed;
            }
        }

        return $result;
    }
}
