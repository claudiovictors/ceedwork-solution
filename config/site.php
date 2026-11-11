<?php

/*
|--------------------------------------------------------------------------
| Configuração base do site
|--------------------------------------------------------------------------
|
| Valores por defeito do conteúdo institucional. A base de dados
| (tabela settings) sobrepõe-se a estes valores quando existir um
| registo gravado no dashboard.
|
*/

return [

    'general' => [
        'site_name' => 'Ceedwork-Solutions',
        'tagline' => 'Soluções de tecnologia para o seu negócio crescer.',
        'logo' => 'assets/images/core/logo.png',
        'logo_white' => 'assets/images/core/logo-white.png',
        'favicon' => 'assets/images/core/favicon.ico',
        'og_image' => 'assets/images/banners/herosection.png',
        'seo_description' => 'Desenvolvimento de software, infraestrutura e consultoria para empresas que querem crescer com segurança e inovação.',
    ],

    'contact' => [
        'phones' => [
            [
                'label' => '+244 947 824 328',
                'href' => 'tel:+244 947 824 328',
            ],
        ],
        'emails' => [
            [
                'type' => 'Geral',
                'email' => 'geral@ceedwork.co.ao',
            ],
            [
                'type' => 'Suporte',
                'email' => 'info@ceedwork-solutions.com',
            ],
        ],
        'address' => 'Rua Da Polícia, Cabinda, Angola',
        'map_url' => 'https://maps.app.goo.gl/g9L8ig8PieojeWMT8',
        'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3971.0581698972233!2d12.188846399999997!3d-5.5583968!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a5dd3f0bb5f797d%3A0xeeae68a407b38dfe!2sCeedwork-solution%2CLda!5e0!3m2!1spt-PT!2sao!4v1793964279518!5m2!1spt-PT!2sao',
        'hours' => 'Segunda a sexta, 08h - 17h',
        'whatsapp_number' => '+244 947 824 328',
        'whatsapp_url' => 'https://wa.me/+244947824328',
    ],

    'social' => [
        'links' => [
            ['network' => 'facebook', 'url' => 'https://web.facebook.com/profile.php?id=100092213826946'],
            ['network' => 'instagram', 'url' => 'https://www.instagram.com/ceedwork_oficial/'],
            ['network' => 'linkedin', 'url' => 'https://www.linkedin.com/company/ceedwork-solution-lda/'],
            ['network' => 'tiktok', 'url' => 'https://www.tiktok.com/@ceedwork'],
            ['network' => 'whatsapp', 'url' => 'https://wa.me/+244947824328'],
        ],
    ],

    'appearance' => [
        'primary' => '#031b3a',
        'secondary' => '#13397c',
        'accent' => '#1baa99',
        'blue' => '#2f96bf',
        'purple' => '#475593',
        'aqua' => '#5eb3bb',
        'light_blue' => '#c3ebfa',
        'background' => '#dae1f1',
    ],

    'assistant' => [
        'enabled' => true,
        'name' => 'Assistente Ceedwork',
        'greeting' => 'Olá! Sou o assistente virtual da Ceedwork. Como posso ajudar?',
        'suggestions' => [
            ['text' => 'Que serviços oferecem?'],
            ['text' => 'Como peço um orçamento?'],
            ['text' => 'Onde ficam localizados?'],
        ],
        'extra_prompt' => '',
    ],

];
