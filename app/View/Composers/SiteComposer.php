<?php

namespace App\View\Composers;

use App\Support\PageContent;
use App\Support\SiteSettings;
use Illuminate\View\View;

final class SiteComposer
{
    public function __construct(
        private readonly SiteSettings $settings,
        private readonly PageContent $content,
    ) {}

    /**
     * Partilha as configurações e o conteúdo editável com as views públicas.
     */
    public function compose(View $view): void
    {
        $view->with([
            'site' => $this->settings,
            'pageContent' => $this->content,
            'theme' => $this->settings->groupWithDefaults('appearance'),
        ]);
    }
}
