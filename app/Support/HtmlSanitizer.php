<?php

namespace App\Support;

use Symfony\Component\HtmlSanitizer\HtmlSanitizer as SymfonyHtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerAction;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

final class HtmlSanitizer
{
    private ?SymfonyHtmlSanitizer $sanitizer = null;

    /**
     * Clean rich text before persisting it.
     */
    public function clean(?string $html): string
    {
        if (blank($html)) {
            return '';
        }

        return $this->sanitizer()->sanitize($html);
    }

    private function sanitizer(): SymfonyHtmlSanitizer
    {
        if ($this->sanitizer instanceof SymfonyHtmlSanitizer) {
            return $this->sanitizer;
        }

        $config = (new HtmlSanitizerConfig)
            ->defaultAction(HtmlSanitizerAction::Block)
            ->allowElement('p')
            ->allowElement('br')
            ->allowElement('h2')
            ->allowElement('h3')
            ->allowElement('strong')
            ->allowElement('em')
            ->allowElement('u')
            ->allowElement('s')
            ->allowElement('ul')
            ->allowElement('ol')
            ->allowElement('li')
            ->allowElement('blockquote')
            ->allowElement('a', ['href', 'title', 'target', 'rel'])
            ->allowElement('img', ['src', 'alt', 'title', 'width', 'height'])
            ->allowElement('pre')
            ->allowElement('code')
            ->allowElement('hr')
            ->allowElement('figure')
            ->allowElement('figcaption')
            ->allowLinkSchemes(['http', 'https', 'mailto', 'tel'])
            ->allowMediaSchemes(['http', 'https'])
            ->allowRelativeLinks()
            ->allowRelativeMedias()
            ->forceHttpsUrls()
            ->forceAttribute('a', 'rel', 'noopener noreferrer')
            ->dropElement('script')
            ->dropElement('style')
            ->dropElement('iframe')
            ->dropElement('object')
            ->dropElement('embed')
            ->dropElement('form')
            ->dropElement('input')
            ->dropElement('button')
            ->dropElement('meta')
            ->dropElement('link')
            ->dropElement('base')
            ->dropElement('svg')
            ->dropElement('math')
            ->withMaxInputLength(100_000);

        return $this->sanitizer = new SymfonyHtmlSanitizer($config);
    }
}
