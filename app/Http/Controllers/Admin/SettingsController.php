<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\ContentFormProcessor;
use App\Support\ContentSchema;
use App\Support\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Exibe as configurações de um grupo.
     */
    public function edit(Request $request, SiteSettings $settings): View
    {
        $groups = ContentSchema::settingsGroups();
        $group = (string) $request->query('group', 'general');

        abort_unless(array_key_exists($group, $groups), 404);

        $fields = ContentSchema::settingsFields($group);

        return view('admin.settings.edit', [
            'groups' => $groups,
            'group' => $group,
            'fields' => $fields,
            'values' => array_replace(ContentSchema::defaults($fields), $settings->group($group)),
        ]);
    }

    /**
     * Guarda as configurações de um grupo.
     */
    public function update(
        Request $request,
        string $group,
        SiteSettings $settings,
        ContentFormProcessor $processor,
    ): RedirectResponse {
        abort_unless(array_key_exists($group, ContentSchema::settingsGroups()), 404);

        $fields = ContentSchema::settingsFields($group);

        $validated = $request->validate(
            ContentSchema::rules($fields),
            [],
            ContentSchema::attributes($fields)
        );

        $data = $processor->process(
            $fields,
            $validated,
            $settings->group($group),
            "site/settings/{$group}",
            $request
        );

        $settings->setGroup($group, $data);

        return redirect()
            ->route('admin.settings.edit', ['group' => $group])
            ->with('status', 'Configurações guardadas com sucesso.');
    }
}
