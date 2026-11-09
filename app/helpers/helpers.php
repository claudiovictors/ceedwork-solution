<?php

// ---------------------------------------------------------------------
// Arquivo Global Helpers
// ---------------------------------------------------------------------

if (! function_exists('site_images')) {
    /**
     * Global image paths available to every page.
     */
    function site_images(): array
    {
        return [
            'banners' => [
                'blessed' => 'assets/images/banners/blessed.webp',
                'chat' => 'assets/images/banners/chat.avif',
                'gracas' => 'assets/images/banners/gracas.webp',
                'herosection' => 'assets/images/banners/herosection.png',
                'kuma' => 'assets/images/banners/kuma.png',
                'maimona' => 'assets/images/banners/maimona.jpeg',
                'mama' => 'assets/images/banners/mama.webp',
                'reunion' => 'assets/images/banners/reunion.avif',
                'reunion_nacional' => 'assets/images/banners/reunion-nacional.avif',
                'salo' => 'assets/images/banners/salo.avif',
            ],

            'core' => [
                'favicon' => 'assets/images/core/favicon.ico',
                'logo' => 'assets/images/core/logo.png',
                'logo_icon' => 'assets/images/core/logo_icon.png',
                'logo_white' => 'assets/images/core/logo-white.png',
                'mark_ceedwork' => 'assets/images/core/mark-ceedwork.png',
                'mark_wiza' => 'assets/images/core/mark-wiza.png',
                'mark_candonga' => 'assets/images/core/mark-candonga.png',
            ],

            'social' => [
                'facebook' => 'https://web.facebook.com/profile.php?id=100092213826946',
                'instagram' => 'https://www.instagram.com/ceedwork_oficial/',
                'linkedin' => 'https://www.linkedin.com/company/ceedwork-solution-lda/',
                'tiktok' => 'https://www.tiktok.com/@ceedwork',
                'whatsapp' => 'https://wa.me/+244947824328',
            ],
        ];
    }
}
