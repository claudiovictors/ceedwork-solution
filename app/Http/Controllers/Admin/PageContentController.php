<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\ContentFormProcessor;
use App\Support\ContentSchema;
use App\Support\PageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageContentController extends Controller
{
    /**
     * Lista as páginas com conteúdo editável.
     */
    public function index(PageContent $content): View
    {
        $pages = ContentSchema::pages();

        $customized = [];

        foreach (array_keys($pages) as $page) {
            $customized[$page] = count($content->customized($page));
        }

        return view('admin.pages.index', [
            'pages' => $pages,
            'customized' => $customized,
        ]);
    }

    /**
     * Exibe o formulário de edição do conteúdo de uma página.
     */
    public function edit(string $page, PageContent $content): View
    {
        abort_unless(ContentSchema::page($page) !== null, 404);

        $sections = ContentSchema::sections($page);
        $values = [];

        foreach ($sections as $sectionKey => $section) {
            $fields = $section['fields'] ?? [];

            $values[$sectionKey] = array_replace(
                ContentSchema::defaults($fields),
                $content->rawSection($page, $sectionKey)
            );
        }

        return view('admin.pages.edit', [
            'page' => $page,
            'definition' => ContentSchema::page($page),
            'sections' => $sections,
            'values' => $values,
        ]);
    }

    /**
     * Guarda o conteúdo de todas as secções de uma página.
     */
    public function update(
        Request $request,
        string $page,
        PageContent $content,
        ContentFormProcessor $processor,
    ): RedirectResponse {
        abort_unless(ContentSchema::page($page) !== null, 404);

        $validated = $request->validate(
            ContentSchema::pageRules($page),
            [],
            ContentSchema::pageAttributes($page)
        );

        foreach (ContentSchema::sections($page) as $sectionKey => $section) {
            $fields = $section['fields'] ?? [];
            $prefix = "{$sectionKey}_";
            $sectionValidated = [];

            foreach (array_keys($fields) as $fieldKey) {
                if (array_key_exists($prefix.$fieldKey, $validated)) {
                    $sectionValidated[$fieldKey] = $validated[$prefix.$fieldKey];
                }
            }

            $data = $processor->process(
                $fields,
                $sectionValidated,
                $content->rawSection($page, $sectionKey),
                "site/pages/{$page}/{$sectionKey}",
                $request,
                $prefix
            );

            $content->save($page, $sectionKey, $data);
        }

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('status', 'Conteúdo da página atualizado com sucesso.');
    }

    /**
     * Remove a personalização de uma secção.
     */
    public function restore(string $page, string $section, PageContent $content): RedirectResponse
    {
        abort_unless(ContentSchema::page($page) !== null, 404);
        abort_unless(array_key_exists($section, ContentSchema::sections($page)), 404);

        $content->restore($page, $section);

        return back()->with('status', 'Secção reposta para o conteúdo original.');
    }
}
