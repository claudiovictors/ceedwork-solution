<?php

/*
|--------------------------------------------------------------------------
| Esquema de conteúdo editável
|--------------------------------------------------------------------------
|
| Descreve os grupos de configurações e as secções das páginas. Os
| formulários do dashboard e as regras de validação são gerados a
| partir desta estrutura.
|
| Tipos suportados: text, textarea, rich, image, url, color, select,
| toggle e repeater.
|
*/

return [

    'settings' => [

        'general' => [
            'label' => 'Geral',
            'icon' => 'bx-cog',
            'description' => 'Identidade do site, logótipos e informação para motores de busca.',
            'fields' => [
                'site_name' => [
                    'type' => 'text',
                    'label' => 'Nome do site',
                    'rules' => ['required', 'string', 'max:120'],
                    'default' => 'Ceedwork-Solutions',
                ],
                'tagline' => [
                    'type' => 'text',
                    'label' => 'Slogan',
                    'rules' => ['nullable', 'string', 'max:180'],
                    'default' => 'Soluções de tecnologia para o seu negócio crescer.',
                ],
                'logo' => [
                    'type' => 'image',
                    'label' => 'Logótipo',
                    'rules' => ['nullable'],
                    'default' => 'assets/images/core/logo.png',
                    'help' => 'JPG, PNG ou WebP até 5 MB.',
                ],
                'logo_white' => [
                    'type' => 'image',
                    'label' => 'Logótipo branco',
                    'rules' => ['nullable'],
                    'default' => 'assets/images/core/logo-white.png',
                    'help' => 'Usado no rodapé e no menu mobile.',
                ],
                'favicon' => [
                    'type' => 'image',
                    'label' => 'Favicon',
                    'allow_ico' => true,
                    'rules' => ['nullable'],
                    'default' => 'assets/images/core/favicon.ico',
                    'help' => 'ICO, PNG, JPG ou WebP até 2 MB.',
                ],
                'og_image' => [
                    'type' => 'image',
                    'label' => 'Imagem Open Graph',
                    'rules' => ['nullable'],
                    'default' => 'assets/images/banners/herosection.png',
                    'help' => 'Imagem mostrada ao partilhar o site nas redes sociais.',
                ],
                'seo_description' => [
                    'type' => 'textarea',
                    'label' => 'Descrição SEO padrão',
                    'rules' => ['nullable', 'string', 'max:300'],
                    'default' => 'Desenvolvimento de software, infraestrutura e consultoria para empresas que querem crescer com segurança e inovação.',
                ],
            ],
        ],

        'contact' => [
            'label' => 'Contactos',
            'icon' => 'bx-phone',
            'description' => 'Telefones, emails, endereço, horário e WhatsApp usados em todo o site.',
            'fields' => [
                'phones' => [
                    'type' => 'repeater',
                    'label' => 'Telefones',
                    'item_label' => 'Telefone',
                    'rules' => ['array'],
                    'fields' => [
                        'label' => [
                            'type' => 'text',
                            'label' => 'Número',
                            'rules' => ['required', 'string', 'max:40'],
                        ],
                        'href' => [
                            'type' => 'text',
                            'label' => 'Link (tel:)',
                            'rules' => ['required', 'string', 'max:80'],
                        ],
                    ],
                    'default' => [
                        ['label' => '+244 947 824 328', 'href' => 'tel:+244 947 824 328'],
                    ],
                ],
                'emails' => [
                    'type' => 'repeater',
                    'label' => 'Emails',
                    'item_label' => 'Email',
                    'rules' => ['array'],
                    'fields' => [
                        'type' => [
                            'type' => 'select',
                            'label' => 'Tipo',
                            'options' => ['Geral' => 'Geral', 'Suporte' => 'Suporte', 'Comercial' => 'Comercial'],
                            'rules' => ['required', 'string'],
                        ],
                        'email' => [
                            'type' => 'text',
                            'label' => 'Email',
                            'rules' => ['required', 'email', 'max:150'],
                        ],
                    ],
                    'default' => [
                        ['type' => 'Geral', 'email' => 'geral@ceedwork.co.ao'],
                        ['type' => 'Suporte', 'email' => 'info@ceedwork-solutions.com'],
                    ],
                ],
                'address' => [
                    'type' => 'text',
                    'label' => 'Endereço',
                    'rules' => ['required', 'string', 'max:200'],
                    'default' => 'Rua Da Polícia, Cabinda, Angola',
                ],
                'map_url' => [
                    'type' => 'url',
                    'label' => 'URL do mapa',
                    'rules' => ['nullable', 'string', 'max:2048'],
                    'default' => 'https://maps.app.goo.gl/g9L8ig8PieojeWMT8',
                ],
                'map_embed_url' => [
                    'type' => 'url',
                    'label' => 'URL do mapa (embed)',
                    'rules' => ['nullable', 'string', 'max:2048'],
                    'default' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3971.0581698972233!2d12.188846399999997!3d-5.5583968!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a5dd3f0bb5f797d%3A0xeeae68a407b38dfe!2sCeedwork-solution%2CLda!5e0!3m2!1spt-PT!2sao!4v1793964279518!5m2!1spt-PT!2sao',
                    'help' => 'Endereço usado no iframe do mapa na página Sobre nós.',
                ],
                'hours' => [
                    'type' => 'text',
                    'label' => 'Horário',
                    'rules' => ['required', 'string', 'max:120'],
                    'default' => 'Segunda a sexta, 08h - 17h',
                ],
                'whatsapp_number' => [
                    'type' => 'text',
                    'label' => 'Número do WhatsApp',
                    'rules' => ['required', 'string', 'max:40'],
                    'default' => '+244 947 824 328',
                ],
                'whatsapp_url' => [
                    'type' => 'url',
                    'label' => 'URL do WhatsApp',
                    'rules' => ['required', 'string', 'max:2048'],
                    'default' => 'https://wa.me/+244947824328',
                ],
            ],
        ],

        'social' => [
            'label' => 'Redes sociais',
            'icon' => 'bx-share-alt',
            'description' => 'Ligações apresentadas no rodapé, menu mobile e página de contactos.',
            'fields' => [
                'links' => [
                    'type' => 'repeater',
                    'label' => 'Redes sociais',
                    'item_label' => 'Rede',
                    'rules' => ['array'],
                    'fields' => [
                        'network' => [
                            'type' => 'select',
                            'label' => 'Rede',
                            'options' => [
                                'facebook' => 'Facebook',
                                'instagram' => 'Instagram',
                                'linkedin' => 'LinkedIn',
                                'tiktok' => 'TikTok',
                                'whatsapp' => 'WhatsApp',
                                'youtube' => 'YouTube',
                                'x' => 'X (Twitter)',
                                'github' => 'GitHub',
                            ],
                            'rules' => ['required', 'string'],
                        ],
                        'url' => [
                            'type' => 'url',
                            'label' => 'URL',
                            'rules' => ['required', 'string', 'max:2048'],
                        ],
                    ],
                    'default' => [
                        ['network' => 'facebook', 'url' => 'https://web.facebook.com/profile.php?id=100092213826946'],
                        ['network' => 'instagram', 'url' => 'https://www.instagram.com/ceedwork_oficial/'],
                        ['network' => 'linkedin', 'url' => 'https://www.linkedin.com/company/ceedwork-solution-lda/'],
                        ['network' => 'tiktok', 'url' => 'https://www.tiktok.com/@ceedwork'],
                        ['network' => 'whatsapp', 'url' => 'https://wa.me/+244947824328'],
                    ],
                ],
            ],
        ],

        'appearance' => [
            'label' => 'Aparência',
            'icon' => 'bx-palette',
            'description' => 'Paleta de cores do site. As cores derivadas são calculadas automaticamente.',
            'fields' => [
                'primary' => [
                    'type' => 'color',
                    'label' => 'Cor primária',
                    'rules' => ['required', 'string'],
                    'default' => '#031b3a',
                ],
                'secondary' => [
                    'type' => 'color',
                    'label' => 'Cor secundária',
                    'rules' => ['required', 'string'],
                    'default' => '#13397c',
                ],
                'accent' => [
                    'type' => 'color',
                    'label' => 'Cor de destaque',
                    'rules' => ['required', 'string'],
                    'default' => '#1baa99',
                ],
                'blue' => [
                    'type' => 'color',
                    'label' => 'Azul',
                    'rules' => ['required', 'string'],
                    'default' => '#2f96bf',
                ],
                'purple' => [
                    'type' => 'color',
                    'label' => 'Roxo',
                    'rules' => ['required', 'string'],
                    'default' => '#475593',
                ],
                'aqua' => [
                    'type' => 'color',
                    'label' => 'Aqua',
                    'rules' => ['required', 'string'],
                    'default' => '#5eb3bb',
                ],
                'light_blue' => [
                    'type' => 'color',
                    'label' => 'Azul claro',
                    'rules' => ['required', 'string'],
                    'default' => '#c3ebfa',
                ],
                'background' => [
                    'type' => 'color',
                    'label' => 'Fundo',
                    'rules' => ['required', 'string'],
                    'default' => '#dae1f1',
                ],
            ],
        ],

        'assistant' => [
            'label' => 'Assistente virtual',
            'icon' => 'bx-bot',
            'description' => 'Comportamento e mensagens do assistente virtual do site.',
            'fields' => [
                'enabled' => [
                    'type' => 'toggle',
                    'label' => 'Ativar assistente virtual',
                    'rules' => ['boolean'],
                    'default' => true,
                ],
                'name' => [
                    'type' => 'text',
                    'label' => 'Nome do assistente',
                    'rules' => ['required', 'string', 'max:80'],
                    'default' => 'Assistente Ceedwork',
                ],
                'greeting' => [
                    'type' => 'textarea',
                    'label' => 'Saudação',
                    'rules' => ['required', 'string', 'max:300'],
                    'default' => 'Olá! Sou o assistente virtual da Ceedwork. Como posso ajudar?',
                ],
                'suggestions' => [
                    'type' => 'repeater',
                    'label' => 'Sugestões de perguntas',
                    'item_label' => 'Sugestão',
                    'rules' => ['array'],
                    'fields' => [
                        'text' => [
                            'type' => 'text',
                            'label' => 'Texto',
                            'rules' => ['required', 'string', 'max:120'],
                        ],
                    ],
                    'default' => [
                        ['text' => 'Que serviços oferecem?'],
                        ['text' => 'Como peço um orçamento?'],
                        ['text' => 'Onde ficam localizados?'],
                    ],
                ],
                'extra_prompt' => [
                    'type' => 'textarea',
                    'label' => 'Texto extra para o prompt do sistema',
                    'rules' => ['nullable', 'string', 'max:1500'],
                    'default' => '',
                    'help' => 'Informação adicional sobre a empresa. Máximo de 1500 caracteres.',
                ],
            ],
        ],
    ],

    'pages' => [

        'home' => [
            'label' => 'Home',
            'icon' => 'bx-home',
            'sections' => [
                'hero' => [
                    'label' => 'Hero',
                    'description' => 'Bloco principal da página inicial.',
                    'fields' => [
                        'title' => [
                            'type' => 'text',
                            'label' => 'Título',
                            'rules' => ['required', 'string', 'max:180'],
                            'default' => 'Soluções de tecnologia que impulsionam o seu negócio.',
                        ],
                        'text' => [
                            'type' => 'textarea',
                            'label' => 'Texto de apoio',
                            'rules' => ['required', 'string', 'max:500'],
                            'default' => 'Desenvolvimento de software, infraestrutura e consultoria para empresas que querem crescer com segurança e inovação.',
                        ],
                        'primary_label' => [
                            'type' => 'text',
                            'label' => 'Rótulo do primeiro botão',
                            'rules' => ['required', 'string', 'max:60'],
                            'default' => 'Saber mais',
                        ],
                        'primary_link' => [
                            'type' => 'url',
                            'label' => 'Link do primeiro botão',
                            'rules' => ['required', 'string', 'max:2048'],
                            'default' => '/about-us',
                        ],
                        'secondary_label' => [
                            'type' => 'text',
                            'label' => 'Rótulo do segundo botão',
                            'rules' => ['required', 'string', 'max:60'],
                            'default' => 'Fale connosco',
                        ],
                        'secondary_link' => [
                            'type' => 'url',
                            'label' => 'Link do segundo botão',
                            'rules' => ['required', 'string', 'max:2048'],
                            'default' => '/contact',
                        ],
                        'background_image' => [
                            'type' => 'image',
                            'label' => 'Imagem de fundo',
                            'rules' => ['nullable'],
                            'default' => 'assets/images/banners/herosection.png',
                        ],
                        'featured_image' => [
                            'type' => 'image',
                            'label' => 'Imagem de destaque',
                            'rules' => ['nullable'],
                            'default' => 'assets/images/banners/herosection.png',
                        ],
                        'featured_image_alt' => [
                            'type' => 'text',
                            'label' => 'Texto alternativo da imagem de destaque',
                            'rules' => ['required', 'string', 'max:180'],
                            'default' => 'Equipa da Ceedwork a trabalhar',
                        ],
                        'show_featured' => [
                            'type' => 'toggle',
                            'label' => 'Mostrar imagem de destaque',
                            'rules' => ['boolean'],
                            'default' => true,
                        ],
                    ],
                ],
                'highlights' => [
                    'label' => 'Destaques',
                    'description' => 'Cabeçalho da lista de notícias em destaque.',
                    'fields' => [
                        'eyebrow' => [
                            'type' => 'text',
                            'label' => 'Rótulo superior',
                            'rules' => ['nullable', 'string', 'max:80'],
                            'default' => 'Nossos Serviços',
                        ],
                        'title' => [
                            'type' => 'text',
                            'label' => 'Título',
                            'rules' => ['required', 'string', 'max:120'],
                            'default' => 'Destaques',
                        ],
                    ],
                ],
                'services' => [
                    'label' => 'Serviços',
                    'description' => 'Blocos de serviços apresentados na página inicial.',
                    'fields' => [
                        'items' => [
                            'type' => 'repeater',
                            'label' => 'Serviços',
                            'item_label' => 'Serviço',
                            'rules' => ['array'],
                            'fields' => [
                                'eyebrow' => [
                                    'type' => 'text',
                                    'label' => 'Rótulo superior',
                                    'rules' => ['required', 'string', 'max:80'],
                                ],
                                'title' => [
                                    'type' => 'text',
                                    'label' => 'Título',
                                    'rules' => ['required', 'string', 'max:120'],
                                ],
                                'text' => [
                                    'type' => 'rich',
                                    'label' => 'Texto',
                                    'rules' => ['required', 'string', 'max:1000'],
                                ],
                                'link' => [
                                    'type' => 'text',
                                    'label' => 'Link do botão',
                                    'rules' => ['required', 'string', 'max:2048'],
                                ],
                                'images' => [
                                    'type' => 'textarea',
                                    'label' => 'Imagens (uma por linha)',
                                    'help' => 'Cada linha aceita um caminho local (assets/images/...) ou uma URL.',
                                    'rules' => ['nullable', 'string', 'max:8000'],
                                ],
                            ],
                            'default' => [],
                        ],
                    ],
                ],
                'brands' => [
                    'label' => 'Marcas',
                    'description' => 'Marcas apresentadas no topo da página inicial.',
                    'fields' => [
                        'items' => [
                            'type' => 'repeater',
                            'label' => 'Marcas',
                            'item_label' => 'Marca',
                            'rules' => ['array'],
                            'fields' => [
                                'name' => [
                                    'type' => 'text',
                                    'label' => 'Nome',
                                    'rules' => ['required', 'string', 'max:80'],
                                ],
                                'image' => [
                                    'type' => 'text',
                                    'label' => 'Imagem (caminho ou URL)',
                                    'help' => 'Ex.: assets/images/core/mark-ceedwork.png ou https://...',
                                    'rules' => ['required', 'string', 'max:2048'],
                                ],
                                'url' => [
                                    'type' => 'text',
                                    'label' => 'Link',
                                    'rules' => ['nullable', 'string', 'max:2048'],
                                ],
                            ],
                            'default' => [
                                ['name' => 'Ceedwork Solution', 'image' => 'assets/images/core/mark-ceedwork.png', 'url' => '/services'],
                                ['name' => 'Ceedwork Wyza', 'image' => 'assets/images/core/mark-wiza.png', 'url' => 'https://wyza.ceedwork-solution.com/'],
                                ['name' => 'CANDONGA', 'image' => 'assets/images/core/mark-candonga.png', 'url' => '/services'],
                            ],
                        ],
                    ],
                ],
                'partners' => [
                    'label' => 'Parceiros',
                    'description' => 'Parceiros apresentados na página inicial.',
                    'fields' => [
                        'eyebrow' => [
                            'type' => 'text',
                            'label' => 'Rótulo superior',
                            'rules' => ['nullable', 'string', 'max:80'],
                            'default' => 'Parcerias',
                        ],
                        'title' => [
                            'type' => 'text',
                            'label' => 'Título',
                            'rules' => ['required', 'string', 'max:120'],
                            'default' => 'Os nossos parceiros',
                        ],
                        'items' => [
                            'type' => 'repeater',
                            'label' => 'Parceiros',
                            'item_label' => 'Parceiro',
                            'rules' => ['array'],
                            'fields' => [
                                'name' => [
                                    'type' => 'text',
                                    'label' => 'Nome',
                                    'rules' => ['required', 'string', 'max:80'],
                                ],
                                'image' => [
                                    'type' => 'text',
                                    'label' => 'Imagem (caminho ou URL)',
                                    'help' => 'Ex.: assets/images/banners/maimona.jpeg ou https://...',
                                    'rules' => ['required', 'string', 'max:2048'],
                                ],
                                'url' => [
                                    'type' => 'text',
                                    'label' => 'Link',
                                    'rules' => ['nullable', 'string', 'max:2048'],
                                ],
                            ],
                            'default' => [
                                ['name' => 'Maimona', 'image' => 'assets/images/banners/maimona.jpeg', 'url' => null],
                                ['name' => 'Blessed', 'image' => 'assets/images/banners/blessed.webp', 'url' => null],
                                ['name' => 'Graças', 'image' => 'assets/images/banners/gracas.webp', 'url' => null],
                                ['name' => 'Kuma', 'image' => 'assets/images/banners/kuma.png', 'url' => null],
                                ['name' => 'Mama', 'image' => 'assets/images/banners/mama.webp', 'url' => null],
                            ],
                        ],
                    ],
                ],
                'cta' => [
                    'label' => 'Chamada final (CTA)',
                    'description' => 'Bloco de chamada à ação no fim da página.',
                    'fields' => [
                        'eyebrow' => [
                            'type' => 'text',
                            'label' => 'Rótulo superior',
                            'rules' => ['nullable', 'string', 'max:80'],
                            'default' => 'Vamos conversar',
                        ],
                        'title' => [
                            'type' => 'text',
                            'label' => 'Título',
                            'rules' => ['required', 'string', 'max:120'],
                            'default' => 'Tem um projeto em mente?',
                        ],
                        'text' => [
                            'type' => 'textarea',
                            'label' => 'Texto',
                            'rules' => ['nullable', 'string', 'max:500'],
                            'default' => 'Fale connosco e receba uma proposta adaptada às suas necessidades.',
                        ],
                        'button_label' => [
                            'type' => 'text',
                            'label' => 'Rótulo do botão',
                            'rules' => ['required', 'string', 'max:60'],
                            'default' => 'Fale connosco',
                        ],
                        'button_link' => [
                            'type' => 'url',
                            'label' => 'Link do botão',
                            'rules' => ['required', 'string', 'max:2048'],
                            'default' => '/contact',
                        ],
                    ],
                ],
            ],
        ],

        'about' => [
            'label' => 'Sobre nós',
            'icon' => 'bx-info-circle',
            'sections' => [
                'banner' => [
                    'label' => 'Banner',
                    'description' => 'Cabeçalho da página Sobre nós.',
                    'fields' => [
                        'title' => [
                            'type' => 'text',
                            'label' => 'Título',
                            'rules' => ['required', 'string', 'max:120'],
                            'default' => 'Quem somos',
                        ],
                        'image' => [
                            'type' => 'image',
                            'label' => 'Imagem do banner',
                            'rules' => ['nullable'],
                            'default' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&w=1600&q=70',
                        ],
                        'image_alt' => [
                            'type' => 'text',
                            'label' => 'Texto alternativo do banner',
                            'rules' => ['required', 'string', 'max:180'],
                            'default' => 'Ceedwork-Solutions',
                        ],
                    ],
                ],
                'intro' => [
                    'label' => 'Introdução',
                    'description' => 'Dois parágrafos de apresentação da empresa.',
                    'fields' => [
                        'paragraph_1' => [
                            'type' => 'rich',
                            'label' => 'Primeiro parágrafo',
                            'rules' => ['required', 'string'],
                            'default' => 'A Ceedwork-Solutions é uma empresa angolana de tecnologia especializada no desenvolvimento de soluções digitais inovadoras. Localizados na província de Cabinda, próxima Rua Da Polícia, estamos comprometidos em oferecer serviços de alta qualidade que atendam às necessidades específicas dos nossos clientes.',
                        ],
                        'paragraph_2' => [
                            'type' => 'rich',
                            'label' => 'Segundo parágrafo',
                            'rules' => ['required', 'string'],
                            'default' => 'Desde a nossa fundação, temos trabalhado incansavelmente para oferecer soluções tecnológicas que não apenas atendam às expectativas, mas que superem os padrões do mercado. Com uma equipa de profissionais experientes e dedicados, oferecemos soluções em <strong>desenvolvimento de software, sistemas web, aplicativos mobile e sites institucionais</strong>.',
                        ],
                    ],
                ],
                'images' => [
                    'label' => 'Imagens',
                    'description' => 'Colagens e imagem da missão, com texto alternativo obrigatório.',
                    'fields' => [
                        'collage_1' => [
                            'type' => 'image',
                            'label' => 'Colagem 1',
                            'rules' => ['nullable'],
                            'default' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=900&q=75',
                        ],
                        'collage_1_alt' => [
                            'type' => 'text',
                            'label' => 'Texto alternativo da colagem 1',
                            'rules' => ['required', 'string', 'max:180'],
                            'default' => 'Equipa da Ceedwork em reunião',
                        ],
                        'collage_2' => [
                            'type' => 'image',
                            'label' => 'Colagem 2',
                            'rules' => ['nullable'],
                            'default' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=900&q=75',
                        ],
                        'collage_2_alt' => [
                            'type' => 'text',
                            'label' => 'Texto alternativo da colagem 2',
                            'rules' => ['required', 'string', 'max:180'],
                            'default' => 'Escritório da Ceedwork',
                        ],
                        'mission_image' => [
                            'type' => 'image',
                            'label' => 'Imagem da missão',
                            'rules' => ['nullable'],
                            'default' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=900&q=75',
                        ],
                        'mission_image_alt' => [
                            'type' => 'text',
                            'label' => 'Texto alternativo da imagem da missão',
                            'rules' => ['required', 'string', 'max:180'],
                            'default' => 'Infraestrutura tecnológica da Ceedwork',
                        ],
                        'vision_1' => [
                            'type' => 'image',
                            'label' => 'Imagem da visão 1',
                            'rules' => ['nullable'],
                            'default' => 'https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=900&q=75',
                        ],
                        'vision_1_alt' => [
                            'type' => 'text',
                            'label' => 'Texto alternativo da imagem da visão 1',
                            'rules' => ['required', 'string', 'max:180'],
                            'default' => 'Espaço de trabalho da Ceedwork',
                        ],
                        'vision_2' => [
                            'type' => 'image',
                            'label' => 'Imagem da visão 2',
                            'rules' => ['nullable'],
                            'default' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=900&q=75',
                        ],
                        'vision_2_alt' => [
                            'type' => 'text',
                            'label' => 'Texto alternativo da imagem da visão 2',
                            'rules' => ['required', 'string', 'max:180'],
                            'default' => 'Reunião de equipa da Ceedwork',
                        ],
                    ],
                ],
                'mission' => [
                    'label' => 'Missão',
                    'fields' => [
                        'title' => [
                            'type' => 'text',
                            'label' => 'Título',
                            'rules' => ['required', 'string', 'max:120'],
                            'default' => 'Nossa missão',
                        ],
                        'body' => [
                            'type' => 'rich',
                            'label' => 'Texto',
                            'rules' => ['required', 'string'],
                            'default' => 'Oferecer soluções tecnológicas inovadoras e personalizadas que impulsionem o crescimento e eficiência dos negócios dos nossos clientes, contribuindo para o desenvolvimento tecnológico de Angola e da região.',
                        ],
                    ],
                ],
                'vision' => [
                    'label' => 'Visão',
                    'fields' => [
                        'title' => [
                            'type' => 'text',
                            'label' => 'Título',
                            'rules' => ['required', 'string', 'max:120'],
                            'default' => 'Nossa visão',
                        ],
                        'body' => [
                            'type' => 'rich',
                            'label' => 'Texto',
                            'rules' => ['required', 'string'],
                            'default' => 'Ser reconhecida como a principal provedora de soluções tecnológicas em Angola, destacando-nos pela excelência, inovação e compromisso com os nossos clientes.',
                        ],
                    ],
                ],
                'values' => [
                    'label' => 'Valores',
                    'fields' => [
                        'title' => [
                            'type' => 'text',
                            'label' => 'Título',
                            'rules' => ['required', 'string', 'max:120'],
                            'default' => 'Nossos valores',
                        ],
                        'items' => [
                            'type' => 'repeater',
                            'label' => 'Valores',
                            'item_label' => 'Valor',
                            'rules' => ['array'],
                            'fields' => [
                                'icon' => [
                                    'type' => 'text',
                                    'label' => 'Ícone Boxicons',
                                    'rules' => ['required', 'string', 'max:80'],
                                ],
                                'title' => [
                                    'type' => 'text',
                                    'label' => 'Título',
                                    'rules' => ['required', 'string', 'max:80'],
                                ],
                                'text' => [
                                    'type' => 'textarea',
                                    'label' => 'Texto',
                                    'rules' => ['required', 'string', 'max:300'],
                                ],
                            ],
                            'default' => [
                                ['icon' => 'bx-medal', 'title' => 'Excelência', 'text' => 'Compromisso com a qualidade em todos os nossos serviços.'],
                                ['icon' => 'bx-bulb', 'title' => 'Inovação', 'text' => 'Busca constante por soluções criativas e eficientes.'],
                                ['icon' => 'bx-badge-check', 'title' => 'Compromisso', 'text' => 'Dedicação total para atender e superar as expectativas dos clientes.'],
                                ['icon' => 'bx-shield-quarter', 'title' => 'Ética', 'text' => 'Conduta transparente e responsável em todas as nossas ações.'],
                                ['icon' => 'bx-group', 'title' => 'Parceria', 'text' => 'Relacionamentos duradouros baseados na confiança e colaboração.'],
                            ],
                        ],
                    ],
                ],
                'location' => [
                    'label' => 'Localização',
                    'fields' => [
                        'title' => [
                            'type' => 'text',
                            'label' => 'Título',
                            'rules' => ['required', 'string', 'max:120'],
                            'default' => 'Nossa localização',
                        ],
                        'card_1_title' => [
                            'type' => 'text',
                            'label' => 'Título do primeiro cartão',
                            'rules' => ['required', 'string', 'max:80'],
                            'default' => 'Angola - Cabinda',
                        ],
                        'card_1_text' => [
                            'type' => 'text',
                            'label' => 'Texto do primeiro cartão',
                            'rules' => ['required', 'string', 'max:180'],
                            'default' => 'Rua Da Polícia, Cabinda',
                        ],
                        'card_2_title' => [
                            'type' => 'text',
                            'label' => 'Título do segundo cartão',
                            'rules' => ['required', 'string', 'max:80'],
                            'default' => 'Presença regional',
                        ],
                        'card_2_text' => [
                            'type' => 'text',
                            'label' => 'Texto do segundo cartão',
                            'rules' => ['required', 'string', 'max:180'],
                            'default' => 'Servindo clientes em toda a região',
                        ],
                    ],
                ],
            ],
        ],

        'contact' => [
            'label' => 'Contactos',
            'icon' => 'bx-envelope',
            'sections' => [
                'banner' => [
                    'label' => 'Banner',
                    'fields' => [
                        'title' => [
                            'type' => 'text',
                            'label' => 'Título',
                            'rules' => ['required', 'string', 'max:120'],
                            'default' => 'Contactos',
                        ],
                        'image' => [
                            'type' => 'image',
                            'label' => 'Imagem do banner',
                            'rules' => ['nullable'],
                            'default' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&w=1600&q=70',
                        ],
                        'image_alt' => [
                            'type' => 'text',
                            'label' => 'Texto alternativo do banner',
                            'rules' => ['required', 'string', 'max:180'],
                            'default' => 'Contactos da Ceedwork-Solutions',
                        ],
                    ],
                ],
                'intro' => [
                    'label' => 'Introdução',
                    'fields' => [
                        'eyebrow' => [
                            'type' => 'text',
                            'label' => 'Rótulo superior',
                            'rules' => ['nullable', 'string', 'max:80'],
                            'default' => 'Fale connosco',
                        ],
                        'title' => [
                            'type' => 'text',
                            'label' => 'Título',
                            'rules' => ['required', 'string', 'max:120'],
                            'default' => 'Envie-nos uma mensagem',
                        ],
                        'text' => [
                            'type' => 'textarea',
                            'label' => 'Texto',
                            'rules' => ['required', 'string', 'max:500'],
                            'default' => 'Tem um projeto em mente, uma dúvida ou precisa de ajuda? Preencha o formulário e a nossa equipe responde o mais breve possível.',
                        ],
                        'quick_1' => [
                            'type' => 'text',
                            'label' => 'Texto de apoio 1',
                            'rules' => ['nullable', 'string', 'max:180'],
                            'default' => 'Respondemos nos dias úteis, dentro do horário de atendimento.',
                        ],
                        'quick_2' => [
                            'type' => 'text',
                            'label' => 'Texto de apoio 2',
                            'rules' => ['nullable', 'string', 'max:180'],
                            'default' => '',
                        ],
                    ],
                ],
                'faq' => [
                    'label' => 'Perguntas frequentes',
                    'fields' => [
                        'eyebrow' => [
                            'type' => 'text',
                            'label' => 'Rótulo superior',
                            'rules' => ['nullable', 'string', 'max:80'],
                            'default' => 'Dúvidas',
                        ],
                        'title' => [
                            'type' => 'text',
                            'label' => 'Título',
                            'rules' => ['required', 'string', 'max:120'],
                            'default' => 'Perguntas frequentes',
                        ],
                        'items' => [
                            'type' => 'repeater',
                            'label' => 'Perguntas',
                            'item_label' => 'Pergunta',
                            'rules' => ['array'],
                            'fields' => [
                                'question' => [
                                    'type' => 'text',
                                    'label' => 'Pergunta',
                                    'rules' => ['required', 'string', 'max:200'],
                                ],
                                'answer' => [
                                    'type' => 'textarea',
                                    'label' => 'Resposta',
                                    'rules' => ['required', 'string', 'max:1000'],
                                ],
                            ],
                            'default' => [
                                ['question' => 'Que tipos de projetos a Ceedwork desenvolve?', 'answer' => 'Desenvolvemos software à medida, sistemas web, aplicativos mobile e sites institucionais, sempre adaptados às necessidades de cada cliente.'],
                                ['question' => 'Como posso pedir um orçamento?', 'answer' => 'Preencha o formulário desta página, escreva-nos por email ou ligue. Depois de entendermos o que precisa, enviamos uma proposta com prazos e valores.'],
                                ['question' => 'Quanto tempo leva a desenvolver um projeto?', 'answer' => 'Depende da complexidade e do âmbito. Um site institucional costuma ser mais rápido do que um sistema de gestão completo. O cronograma é definido na proposta.'],
                                ['question' => 'Oferecem suporte depois da entrega?', 'answer' => 'Sim, acompanhamos os projetos após a entrega, com suporte técnico e manutenção. Os detalhes do acompanhamento são combinados em cada projeto.'],
                                ['question' => 'Atendem clientes fora de Cabinda?', 'answer' => 'Estamos sediados em Cabinda e servimos clientes em toda a região. O acompanhamento pode ser feito presencialmente ou à distância.'],
                                ['question' => 'Posso ver exemplos de trabalhos anteriores?', 'answer' => 'Claro! Consulte a página de portfólio ou peça-nos exemplos relacionados com o seu sector.'],
                                ['question' => 'Como falo com o suporte técnico?', 'answer' => 'Use o email de suporte ou o WhatsApp indicados nesta página, ou escolha o assunto "Suporte técnico" no formulário.'],
                            ],
                        ],
                    ],
                ],
                'subjects' => [
                    'label' => 'Assuntos do formulário',
                    'fields' => [
                        'items' => [
                            'type' => 'repeater',
                            'label' => 'Assuntos',
                            'item_label' => 'Assunto',
                            'rules' => ['array'],
                            'fields' => [
                                'subject' => [
                                    'type' => 'text',
                                    'label' => 'Assunto',
                                    'rules' => ['required', 'string', 'max:80'],
                                ],
                            ],
                            'default' => [
                                ['subject' => 'Pedido de orçamento'],
                                ['subject' => 'Suporte técnico'],
                                ['subject' => 'Parcerias'],
                                ['subject' => 'Dúvidas gerais'],
                                ['subject' => 'Outro'],
                            ],
                        ],
                    ],
                ],
            ],
        ],

        'services' => [
            'label' => 'Serviços',
            'icon' => 'bx-briefcase',
            'sections' => [
                'header' => [
                    'label' => 'Cabeçalho',
                    'fields' => [
                        'title' => [
                            'type' => 'text',
                            'label' => 'Título',
                            'rules' => ['required', 'string', 'max:120'],
                            'default' => 'Serviços',
                        ],
                        'intro_eyebrow' => [
                            'type' => 'text',
                            'label' => 'Rótulo da introdução',
                            'rules' => ['nullable', 'string', 'max:80'],
                            'default' => 'O que fazemos',
                        ],
                        'intro_title' => [
                            'type' => 'text',
                            'label' => 'Título da introdução',
                            'rules' => ['required', 'string', 'max:160'],
                            'default' => 'Tecnologia e inovação para transformar instituições',
                        ],
                        'intro' => [
                            'type' => 'rich',
                            'label' => 'Introdução',
                            'rules' => ['nullable', 'string'],
                            'default' => 'A Ceedwork-Solutions disponibiliza um conjunto de soluções tecnológicas desenvolvidas para responder às necessidades de empresas, instituições públicas e privadas. Da criação de softwares à transformação digital, trabalhamos para tornar os processos mais simples, eficientes e seguros.',
                        ],
                        'image' => [
                            'type' => 'image',
                            'label' => 'Imagem do banner',
                            'rules' => ['nullable'],
                            'default' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&w=1600&q=70',
                        ],
                        'image_alt' => [
                            'type' => 'text',
                            'label' => 'Texto alternativo do banner',
                            'rules' => ['required', 'string', 'max:180'],
                            'default' => 'Serviços da Ceedwork-Solutions',
                        ],
                    ],
                ],
                'cta' => [
                    'label' => 'Chamada final (CTA)',
                    'description' => 'Bloco de chamada à ação no fim da página de serviços.',
                    'fields' => [
                        'eyebrow' => [
                            'type' => 'text',
                            'label' => 'Rótulo superior',
                            'rules' => ['nullable', 'string', 'max:80'],
                            'default' => 'Vamos conversar',
                        ],
                        'title' => [
                            'type' => 'text',
                            'label' => 'Título',
                            'rules' => ['required', 'string', 'max:120'],
                            'default' => 'Tem um projeto em mente?',
                        ],
                        'text' => [
                            'type' => 'textarea',
                            'label' => 'Texto',
                            'rules' => ['nullable', 'string', 'max:500'],
                            'default' => 'Seja uma empresa, instituição pública ou privada, estamos preparados para ajudar a transformar as suas necessidades em soluções tecnológicas.',
                        ],
                        'button_label' => [
                            'type' => 'text',
                            'label' => 'Rótulo do botão',
                            'rules' => ['required', 'string', 'max:60'],
                            'default' => 'Fale connosco',
                        ],
                        'button_link' => [
                            'type' => 'url',
                            'label' => 'Link do botão',
                            'rules' => ['required', 'string', 'max:2048'],
                            'default' => '/contact',
                        ],
                    ],
                ],
            ],
        ],

        'portfolio' => [
            'label' => 'Portfólio',
            'icon' => 'bx-folder-open',
            'sections' => [
                'header' => [
                    'label' => 'Cabeçalho',
                    'fields' => [
                        'title' => [
                            'type' => 'text',
                            'label' => 'Título',
                            'rules' => ['required', 'string', 'max:120'],
                            'default' => 'Portfólio',
                        ],
                        'intro' => [
                            'type' => 'rich',
                            'label' => 'Introdução',
                            'rules' => ['nullable', 'string'],
                            'default' => 'Conheça alguns dos projetos desenvolvidos pela Ceedwork-Solutions para empresas e instituições.',
                        ],
                        'image' => [
                            'type' => 'image',
                            'label' => 'Imagem do banner',
                            'rules' => ['nullable'],
                            'default' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&w=1600&q=70',
                        ],
                        'image_alt' => [
                            'type' => 'text',
                            'label' => 'Texto alternativo do banner',
                            'rules' => ['required', 'string', 'max:180'],
                            'default' => 'Portfólio da Ceedwork-Solutions',
                        ],
                    ],
                ],
            ],
        ],

        'news' => [
            'label' => 'Notícias',
            'icon' => 'bx-news',
            'sections' => [
                'header' => [
                    'label' => 'Cabeçalho',
                    'fields' => [
                        'title' => [
                            'type' => 'text',
                            'label' => 'Título',
                            'rules' => ['required', 'string', 'max:120'],
                            'default' => 'Notícias',
                        ],
                        'intro' => [
                            'type' => 'rich',
                            'label' => 'Introdução',
                            'rules' => ['nullable', 'string'],
                            'default' => 'Acompanhe as novidades da Ceedwork-Solutions: projetos, eventos, parcerias e dicas de tecnologia.',
                        ],
                        'image' => [
                            'type' => 'image',
                            'label' => 'Imagem do banner',
                            'rules' => ['nullable'],
                            'default' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&w=1600&q=70',
                        ],
                        'image_alt' => [
                            'type' => 'text',
                            'label' => 'Texto alternativo do banner',
                            'rules' => ['required', 'string', 'max:180'],
                            'default' => 'Notícias da Ceedwork-Solutions',
                        ],
                    ],
                ],
            ],
        ],

        'footer' => [
            'label' => 'Footer',
            'icon' => 'bx-layout',
            'sections' => [
                'institutional' => [
                    'label' => 'Texto institucional',
                    'fields' => [
                        'text' => [
                            'type' => 'textarea',
                            'label' => 'Texto',
                            'rules' => ['required', 'string', 'max:300'],
                            'default' => 'Soluções de tecnologia para o seu negócio crescer.',
                        ],
                    ],
                ],
            ],
        ],
    ],

];
