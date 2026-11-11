<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

final class SiteSettings
{
    private const CACHE_KEY = 'site.settings.v1';

    /**
     * @var array<string, mixed>|null
     */
    private ?array $loaded = null;

    /**
     * Devolve todas as configurações achatadas (grupo.chave).
     *
     * @return array<string, mixed>
     */
    public function all(): array
    {
        if (is_array($this->loaded)) {
            return $this->loaded;
        }

        return $this->loaded = Cache::rememberForever(self::CACHE_KEY, function (): array {
            return Setting::query()
                ->get()
                ->mapWithKeys(fn (Setting $setting): array => [
                    "{$setting->group}.{$setting->key}" => $setting->value,
                ])
                ->all();
        });
    }

    /**
     * Obtém uma configuração, com fallback para os valores por defeito.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $all = $this->all();

        if (array_key_exists($key, $all)) {
            return $all[$key];
        }

        if (Arr::has(config('site', []), $key)) {
            return data_get(config('site'), $key);
        }

        [$group, $field] = array_pad(explode('.', $key, 2), 2, null);

        if ($field !== null) {
            $schemaDefault = data_get(config('site_content.settings'), "{$group}.fields.{$field}.default");

            if ($schemaDefault !== null) {
                return $schemaDefault;
            }
        }

        return $default;
    }

    /**
     * Devolve os valores guardados de um grupo, sem defaults.
     *
     * @return array<string, mixed>
     */
    public function group(string $group): array
    {
        $prefix = "{$group}.";

        return collect($this->all())
            ->filter(fn (mixed $value, string $key): bool => str_starts_with($key, $prefix))
            ->mapWithKeys(fn (mixed $value, string $key): array => [
                substr($key, strlen($prefix)) => $value,
            ])
            ->all();
    }

    /**
     * Devolve os valores de um grupo com os defaults aplicados.
     *
     * @return array<string, mixed>
     */
    public function groupWithDefaults(string $group): array
    {
        return array_replace(
            ContentSchema::defaults(ContentSchema::settingsFields($group)),
            $this->group($group)
        );
    }

    /**
     * Guarda uma configuração individual.
     */
    public function set(string $key, mixed $value): void
    {
        [$group, $field] = array_pad(explode('.', $key, 2), 2, null);

        if ($group === null || $field === null) {
            return;
        }

        Setting::query()->updateOrCreate(
            ['group' => $group, 'key' => $field],
            ['value' => $value]
        );

        $this->flush();
    }

    /**
     * Guarda todas as configurações de um grupo.
     *
     * @param  array<string, mixed>  $values
     */
    public function setGroup(string $group, array $values): void
    {
        DB::transaction(function () use ($group, $values): void {
            foreach ($values as $key => $value) {
                Setting::query()->updateOrCreate(
                    ['group' => $group, 'key' => $key],
                    ['value' => $value]
                );
            }
        });

        $this->flush();
    }

    /**
     * Limpa a cache de configurações.
     */
    public function flush(): void
    {
        $this->loaded = null;

        Cache::forget(self::CACHE_KEY);
    }
}
