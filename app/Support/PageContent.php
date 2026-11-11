<?php

namespace App\Support;

use App\Models\PageSection;
use Illuminate\Support\Facades\Cache;

final class PageContent
{
    private const CACHE_PREFIX = 'site.page_content.v1.';

    /**
     * Devolve todas as secções de uma página com os defaults aplicados.
     *
     * @return array<string, array<string, mixed>>
     */
    public function all(string $page): array
    {
        return Cache::rememberForever(self::CACHE_PREFIX.$page, function () use ($page): array {
            $stored = PageSection::query()
                ->where('page', $page)
                ->get()
                ->keyBy('key');

            $sections = [];

            foreach (ContentSchema::sections($page) as $key => $definition) {
                $defaults = ContentSchema::defaults($definition['fields'] ?? []);
                $data = $stored->get($key)?->data;

                $sections[$key] = array_replace($defaults, is_array($data) ? $data : []);
            }

            return $sections;
        });
    }

    /**
     * Obtém uma secção ou um campo de uma secção.
     */
    public function get(string $page, string $section, ?string $key = null, mixed $default = null): mixed
    {
        $data = data_get($this->all($page), $section, []);

        if ($key === null) {
            return is_array($data) ? $data : [];
        }

        return data_get($data, $key, $default);
    }

    /**
     * Devolve os valores guardados de uma secção, sem defaults.
     *
     * @return array<string, mixed>
     */
    public function rawSection(string $page, string $section): array
    {
        $data = PageSection::query()
            ->where('page', $page)
            ->where('key', $section)
            ->value('data');

        return is_array($data) ? $data : [];
    }

    /**
     * Devolve as secções personalizadas de uma página.
     *
     * @return array<int, string>
     */
    public function customized(string $page): array
    {
        return PageSection::query()
            ->where('page', $page)
            ->pluck('key')
            ->all();
    }

    /**
     * Guarda o conteúdo de uma secção.
     *
     * @param  array<string, mixed>  $data
     */
    public function save(string $page, string $section, array $data): PageSection
    {
        $sectionModel = PageSection::query()->updateOrCreate(
            ['page' => $page, 'key' => $section],
            [
                'title' => $data['title'] ?? null,
                'subtitle' => $data['subtitle'] ?? null,
                'body' => $data['body'] ?? $data['text'] ?? null,
                'data' => $data,
                'is_active' => true,
            ]
        );

        $this->flush($page);

        return $sectionModel;
    }

    /**
     * Remove a personalização de uma secção, voltando aos defaults.
     */
    public function restore(string $page, string $section): void
    {
        PageSection::query()
            ->where('page', $page)
            ->where('key', $section)
            ->delete();

        $this->flush($page);
    }

    /**
     * Limpa a cache de conteúdo das páginas.
     */
    public function flush(?string $page = null): void
    {
        if ($page !== null) {
            Cache::forget(self::CACHE_PREFIX.$page);

            return;
        }

        foreach (array_keys(ContentSchema::pages()) as $pageKey) {
            Cache::forget(self::CACHE_PREFIX.$pageKey);
        }
    }
}
