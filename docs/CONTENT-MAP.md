# Mapa de Conteúdo — Site Ceedwork

> **Fase A — Inventário (sem alterações de código).**
> Levantamento de todo o conteúdo ainda fixo no site público e o destino previsto
> no dashboard. Serve de contrato para as fases B a G.

## Legenda

| Destino | Significado |
| --- | --- |
| `Config. → Geral` | Separador **Configurações › Geral** (`settings`, grupo `general`). |
| `Config. → Contactos` | Separador **Configurações › Contactos** (`settings`, grupo `contact`). |
| `Config. → Redes sociais` | Separador **Configurações › Redes sociais** (`settings`, grupo `social`). |
| `Config. → Aparência` | Separador **Configurações › Aparência** (`settings`, grupo `appearance`). |
| `Config. → Assistente` | Separador **Configurações › Assistente virtual** (`settings`, grupo `assistant`). |
| `Páginas → Home` | Menu **Páginas › Home** (`page_sections`, `page = home`). |
| `Páginas → Sobre nós` | Menu **Páginas › Sobre nós** (`page_sections`, `page = about`). |
| `Páginas → Contactos` | Menu **Páginas › Contactos** (`page_sections`, `page = contact`). |
| `Páginas → Serviços/Portfólio/Notícias` | Cabeçalho de cada listagem (`page_sections`). |
| `Páginas → Footer` | Texto institucional do rodapé (`page_sections`, `page = footer`). |
| `CRUD` | Tabela própria gerida no dashboard (`brands`, `partners`). |
| `Já dinâmico` | Já vem da base de dados (notícias, serviços, projetos). |

**Tipos:** `texto`, `HTML`, `imagem`, `cor`, `link`, `lista`.

---

## 1. Layout global, SEO e cabeçalho

| Conteúdo | Onde está hoje | Tipo | Onde passará a ser editado |
| --- | --- | --- | --- |
| Meta description padrão | `resources/views/layouts/main.blade.php:6` | texto | Config. → Geral → descrição SEO padrão |
| `<title>` da página | `layouts/main.blade.php:8` + `@section('title')` de cada página | texto | Config. → Geral → nome do site + Páginas (título por página) |
| Favicon | `layouts/main.blade.php:11` (`$data['core']['favicon']`) | imagem | Config. → Geral → favicon |
| Open Graph (título/descrição/imagem) | **não existe** | texto/imagem | Config. → Geral → imagem Open Graph + Páginas |
| Boxicons (CDN unpkg) | `layouts/main.blade.php:10` | link | Fora do conteúdo; alojar localmente na Fase F / auditoria |
| Fontes Google (`global.css:1`) | `public/assets/css/global.css:1` | link | Fora do conteúdo; alojar localmente na Fase F / auditoria |
| Paleta de cores | `public/assets/css/global.css:39-51` | cor | Config. → Aparência |
| `--accent-hover` derivado | `global.css:59` (`#148577`) | cor | Calculado no servidor a partir do destaque |
| Logótipo principal | `_navbar.blade.php:31`, `$data['core']['logo']` | imagem | Config. → Geral → logo |
| Logótipo branco | `_navbar.blade.php:40`, `_footer.blade.php:9`, `$data['core']['logo_white']` | imagem | Config. → Geral → logo branco |

## 2. Topbar e navegação (`_navbar`)

| Conteúdo | Onde está hoje | Tipo | Onde passará a ser editado |
| --- | --- | --- | --- |
| Telefone da topbar `+244 947 824 328` | `_navbar.blade.php:6-8` | texto/link | Config. → Contactos → telefones |
| Endereço da topbar `Cabinda, Angola` | `_navbar.blade.php:10-12` | texto | Config. → Contactos → endereço |
| Etiqueta/atalho `Suporte` | `_navbar.blade.php:14-16` | texto/link | Config. → Contactos (rótulo fixo) |
| Rótulo `Navegação` | `_navbar.blade.php:47` | texto | Fixo (estrutura de menu fora de escopo) |
| Links do menu (Início, Sobre, Serviços, Portfólio, Notícias, Contactos) | `_navbar.blade.php:49-56` | lista/link | Fixo (gestor de menus fora de escopo) |
| WhatsApp da gaveta (usado como `tel:`) | `_navbar.blade.php:62` | link | Config. → Contactos → número WhatsApp |
| Email `geral@ceedwork.co.ao` | `_navbar.blade.php:63` | texto/link | Config. → Contactos → emails |
| Endereço na gaveta | `_navbar.blade.php:65` | texto | Config. → Contactos → endereço |
| Redes sociais (Facebook, Instagram, TikTok, LinkedIn, WhatsApp) | `_navbar.blade.php:71-77` | lista/link | Config. → Redes sociais |
| **Bug:** ícone LinkedIn usa URL do Instagram | `_navbar.blade.php:75` | link | Corrigido ao passar a lista dinâmica |
| Script inline do menu | `_navbar.blade.php:86-116` | código | Mover para `public/js/` (Fase F / auditoria) |

## 3. Rodapé (`_footer`)

| Conteúdo | Onde está hoje | Tipo | Onde passará a ser editado |
| --- | --- | --- | --- |
| Texto institucional `Soluções de tecnologia para o seu negócio crescer.` | `_footer.blade.php:12` | texto | Páginas → Footer → texto institucional |
| Localidade `Cabinda, Angola` | `_footer.blade.php:13` | texto | Config. → Contactos → endereço |
| Título/Newsletter | `_footer.blade.php:15-21` | texto | Fixo (formulário sem backend; fora de escopo) |
| Links de Serviços/Empresa | `_footer.blade.php:26-39` | lista/link | Fixo (navegação) |
| Endereço `Rua Da Polícia, Cabinda` | `_footer.blade.php:49` | texto | Config. → Contactos → endereço |
| Horário `Seg-Sex: 08h-17h` | `_footer.blade.php:56` | texto | Config. → Contactos → horário |
| Telefone | `_footer.blade.php:63` | texto/link | Config. → Contactos → telefones |
| Email `info@ceedwork-solutions.com` | `_footer.blade.php:70` | texto/link | Config. → Contactos → emails |
| Redes sociais | `_footer.blade.php:78-84` | lista/link | Config. → Redes sociais |
| Copyright `Ceedwork … © {ano}` | `_footer.blade.php:86-88` | texto | Config. → Geral → nome do site |
| Script `back to top` | `_footer.blade.php:99-111` | código | Mover para `public/js/` |

## 4. Home

### 4.1 Hero (`_herosection`)

| Conteúdo | Onde está hoje | Tipo | Onde passará a ser editado |
| --- | --- | --- | --- |
| Imagem de fundo | `_herosection.blade.php:1` (`$data['banners']['herosection']`) | imagem | Páginas → Home → Hero → imagem de fundo |
| Imagem de destaque | `_herosection.blade.php:5` | imagem | Páginas → Home → Hero → imagem de destaque (+ ocultar) |
| Texto alternativo da imagem | `_herosection.blade.php:5` (`alt`) | texto | Páginas → Home → Hero → alt |
| Título `Soluções de tecnologia que impulsionam o seu negócio.` | `_herosection.blade.php:9` | texto | Páginas → Home → Hero → título |
| Texto de apoio | `_herosection.blade.php:11` | texto | Páginas → Home → Hero → texto |
| Botão `Saber mais` → `route('about')` | `_herosection.blade.php:14-16` | texto/link | Páginas → Home → Hero → botão 1 (rótulo + link) |
| Botão `Fale connosco` → `route('contact')` | `_herosection.blade.php:17-19` | texto/link | Páginas → Home → Hero → botão 2 (rótulo + link) |

### 4.2 Marcas (`_marcas`)

| Conteúdo | Onde está hoje | Tipo | Onde passará a ser editado |
| --- | --- | --- | --- |
| 3 marcas (nome, imagem, URL) | `_marcas.blade.php:4-20` | lista/imagem/link | Home → Marcas (**CRUD** `brands`) |
| Abrir em novo separador | `_marcas.blade.php:27-31` | booleano | Home → Marcas → novo separador |
| Ordem | ordem do array | número | Home → Marcas → ordem |
| `aria-label="Áreas de negócio"` | `_marcas.blade.php:23` | texto | Fixo |

### 4.3 Destaques (`_destaques`)

| Conteúdo | Onde está hoje | Tipo | Onde passará a ser editado |
| --- | --- | --- | --- |
| Eyebrow `Nossos Serviços` | `_destaques.blade.php:19` | texto | Páginas → Home → Destaques (título/subtítulo) |
| Título `Destaques` | `_destaques.blade.php:20` | texto | Páginas → Home → Destaques |
| Cartões | `_destaques.blade.php:6-12` | lista | Já dinâmico (notícias) |
| Imagem de reserva `placehold.co` | `_destaques.blade.php:9` | imagem | Placeholder local em `public/assets/images/placeholders/` |
| Botão `Ler mais` | `_destaques.blade.php:47` | texto | Fixo |

### 4.4 Serviços (`_servicos`)

| Conteúdo | Onde está hoje | Tipo | Onde passará a ser editado |
| --- | --- | --- | --- |
| 2 blocos (eyebrow, título, HTML, link) | `_servicos.blade.php:6-35` | HTML/lista | Páginas → Home → Serviços **ou** modelo `Service` |
| 12 imagens Unsplash | `_servicos.blade.php:12-33` | imagem | Placeholders locais / imagens dos serviços |
| `{!! $service['text'] !!}` (HTML) | `_servicos.blade.php:55` | HTML | Sanitizado ao gravar |

### 4.5 Parceiros (`_parceiros`)

| Conteúdo | Onde está hoje | Tipo | Onde passará a ser editado |
| --- | --- | --- | --- |
| 5 parceiros (nome, logo, URL) | `_parceiros.blade.php:4-10` | lista/imagem/link | Home → Parceiros (**CRUD** `partners`) |
| Ordem / ativo | ordem do array | número/booleano | Home → Parceiros → ordem/ativo |
| Eyebrow `Parcerias` e título `Os nossos parceiros` | `_parceiros.blade.php:17-18` | texto | Páginas → Home → Parceiros |
| Script do carrossel | `_parceiros.blade.php:41-104` | código | Mover para `public/js/` |

### 4.6 Chamada final (`_cta`)

| Conteúdo | Onde está hoje | Tipo | Onde passará a ser editado |
| --- | --- | --- | --- |
| Eyebrow, título, texto | `_cta.blade.php:2-4` | texto | Páginas → Home → Chamada final (CTA) |
| Rótulo/link do botão | `_cta.blade.php:5-6` | texto/link | Páginas → Home → CTA |
| Telefone `+244 947 824 328` | `_cta.blade.php:7` | texto/link | Config. → Contactos → telefones |

> Nota: o componente `_cta` não está atualmente incluído na Home; é usado como
> bloco reutilizável. O destino fica preparado para o ligar na Fase F.

## 5. Cabeçalho de páginas internas (`_page-header`)

| Conteúdo | Onde está hoje | Tipo | Onde passará a ser editado |
| --- | --- | --- | --- |
| Título | `_page-header.blade.php:7` + parâmetro de cada página | texto | Páginas → cada página → título do banner |
| Imagem de reserva Unsplash | `_page-header.blade.php:8` | imagem | Páginas → cada página → imagem do banner |
| Breadcrumbs | `_page-header.blade.php:15-29` | lista | Fixo (estrutura) |

## 6. Sobre nós (`pages/about`)

| Conteúdo | Onde está hoje | Tipo | Onde passará a ser editado |
| --- | --- | --- | --- |
| Título/meta SEO | `about.blade.php:4-5` | texto | Páginas → Sobre nós (SEO) |
| Título do banner `Quem somos` | `about.blade.php:8-14` | texto | Páginas → Sobre nós → banner |
| Imagem do banner | usa reserva Unsplash | imagem | Páginas → Sobre nós → banner |
| 2 imagens da colagem (sem alt) | `about.blade.php:36-39` | imagem | Páginas → Sobre nós → imagens (com alt) |
| Parágrafo 1 (intro) | `about.blade.php:42-44` | HTML | Páginas → Sobre nós → introdução (rich) |
| Parágrafo 2 (intro) | `about.blade.php:45-47` | HTML | Páginas → Sobre nós → introdução (rich) |
| Imagem da missão | `about.blade.php:56-58` | imagem | Páginas → Sobre nós → missão → imagem (+ alt) |
| Título e texto da missão | `about.blade.php:61-64` | texto | Páginas → Sobre nós → missão |
| 2 imagens da visão | `about.blade.php:73-76` | imagem | Páginas → Sobre nós → visão → imagens (+ alt) |
| Título e texto da visão | `about.blade.php:79-82` | texto | Páginas → Sobre nós → visão |
| 5 valores (ícone, título, texto) | `about.blade.php:23-29` | lista | Páginas → Sobre nós → valores (repetidor) |
| Título `Nossos valores` | `about.blade.php:91` | texto | Páginas → Sobre nós → valores (título) |
| Título `Nossa localização` | `about.blade.php:110` | texto | Páginas → Sobre nós → localização |
| Cartão `Angola - Cabinda` / `Rua Da Polícia` / link mapa | `about.blade.php:114-124` | texto/link | Páginas → Sobre nós → cartões + Config. → Contactos |
| Cartão `Presença regional` | `about.blade.php:126-132` | texto | Páginas → Sobre nós → cartões |
| Iframe do Google Maps (URL longo) | `about.blade.php:138` | link | Config. → Contactos → URL do mapa (embed) |

## 7. Contactos (`pages/contact`)

| Conteúdo | Onde está hoje | Tipo | Onde passará a ser editado |
| --- | --- | --- | --- |
| Título/meta SEO | `contact.blade.php:3-4` | texto | Páginas → Contactos (SEO) |
| Lista de telefones | `contact.blade.php:9-11` | lista/link | Config. → Contactos → telefones |
| Lista de emails | `contact.blade.php:13-15` | lista/link | Config. → Contactos → emails |
| URL WhatsApp | `contact.blade.php:17` | link | Config. → Contactos → número WhatsApp |
| URL do mapa (curto) | `contact.blade.php:18` | link | Config. → Contactos → URL do mapa |
| 7 FAQ (pergunta/resposta) | `contact.blade.php:20-50` | lista | Páginas → Contactos → FAQ (repetidor) |
| Título do banner `Contactos` | `contact.blade.php:53-61` | texto | Páginas → Contactos → banner |
| Rótulos dos cartões (Telefone, Email, Localização, Horário) | `contact.blade.php:69,79,89,98` | texto | Fixo |
| Endereço `Angola - Cabinda` | `contact.blade.php:91` | texto | Config. → Contactos → endereço |
| Horário `Segunda a sexta` / `08h - 17h` | `contact.blade.php:100-101` | texto | Config. → Contactos → horário |
| Eyebrow `Fale connosco`, título e parágrafo de intro | `contact.blade.php:112-116` | texto | Páginas → Contactos → textos de introdução |
| Textos de apoio + email de suporte | `contact.blade.php:118-127` | texto/link | Páginas → Contactos / Config. → Contactos |
| Redes sociais | `contact.blade.php:133-139` | lista/link | Config. → Redes sociais |
| Rótulos do formulário e placeholders | `contact.blade.php:159-208` | texto | Fixo (UI) |
| Assuntos do formulário | `ContactController::SUBJECTS` (`ContactController.php:15-21`) | lista | Páginas → Contactos → assuntos do formulário |
| Eyebrow/título `Perguntas frequentes` | `contact.blade.php:218-219` | texto | Páginas → Contactos → FAQ (título) |
| Script inline do formulário | `contact.blade.php:238-254` | código | Mover para `public/js/` |

## 8. Serviços (`pages/service`)

| Conteúdo | Onde está hoje | Tipo | Onde passará a ser editado |
| --- | --- | --- | --- |
| Título/meta SEO | `service.blade.php:3-4` | texto | Páginas → Serviços (SEO) |
| Título do banner `Serviços` | `service.blade.php:6-14` | texto | Páginas → Serviços → banner |
| Imagem do banner | usa reserva Unsplash | imagem | Páginas → Serviços → banner |
| **9 serviços** (ícone, título, texto, imagem Unsplash, itens) | `service.blade.php:24-155` | lista/HTML/imagem | Modelo `Service` (já com CRUD) |
| Intro (eyebrow, título, parágrafo) | `service.blade.php:158-189` | texto | Páginas → Serviços → introdução |
| Bloco CTA (eyebrow, título, texto, botão, telefone) | `service.blade.php:250-276` | texto/link | Páginas → Serviços → CTA + Config. → Contactos |
| `tel:{{ $data['social']['whatsapp'] }}` (usa URL) | `service.blade.php:146` | link | Config. → Contactos → telefones |
| `+244 900 000 000` (placeholder) | `service.blade.php:147` | texto | Config. → Contactos → telefones |

> **Achado:** o controlador passa `$services` (Eloquent), mas a view volta a
> declarar `$services` com o array fixo (`service.blade.php:24`), ignorando a
> base de dados. A Fase F deve ligar ao modelo `Service`.

## 9. Portfólio (`pages/portfolio`)

| Conteúdo | Onde está hoje | Tipo | Onde passará a ser editado |
| --- | --- | --- | --- |
| Título/meta SEO | `portfolio.blade.php:4-5` | texto | Páginas → Portfólio (SEO) |
| Título do banner `Serviços` | `portfolio.blade.php:11-19` | texto | Páginas → Portfólio → banner |
| Imagem do banner | usa reserva Unsplash | imagem | Páginas → Portfólio → banner |
| Array fixo de "serviços" (3 blocos + Unsplash) | `portfolio.blade.php:22-69` | lista/HTML/imagem | Modelo `Project` (já com CRUD) |
| Intro (eyebrow, título, parágrafo) | `portfolio.blade.php:72-94` | texto | Páginas → Portfólio → introdução |
| CTA + telefone | `portfolio.blade.php:132-152` | texto/link | Páginas → Portfólio → CTA + Config. → Contactos |

> **Achado:** a view `pages/portfolio.blade.php` é uma cópia da página de
> serviços (título "Serviços", array `$services`), ignorando `$projects` enviado
> pelo `PortfolioController`. A Fase F deve reconstruir a listagem a partir de
> `Project`.

## 10. Notícias (`pages/news` e `pages/news-show`)

| Conteúdo | Onde está hoje | Tipo | Onde passará a ser editado |
| --- | --- | --- | --- |
| Título/meta SEO | `news.blade.php:4-5` | texto | Páginas → Notícias (SEO) |
| Título do banner `Notícias` | `news.blade.php:11-19` | texto | Páginas → Notícias → banner |
| Imagem do banner | usa reserva Unsplash | imagem | Páginas → Notícias → banner |
| Fallback de 9 notícias com Unsplash | `news.blade.php:29-93` | lista/imagem | Remover; usar só base de dados + placeholders locais |
| Rótulos `Todas`, `Pesquisar notícias`, `Destaque`, `Ler notícia`, `Últimas notícias`, `Ler mais`, `Ver mais notícias`, estado vazio | `news.blade.php:111-204` | texto | Fixo (UI) ou Páginas → Notícias (textos) |
| Script inline de filtros | `news.blade.php:210-287` | código | Mover para `public/js/` |
| Corpo da notícia `{!! $post['body'] !!}` | `news-show.blade.php:97` | HTML | Já dinâmico (sanitizado no admin) |
| Bio do autor | `news-show.blade.php:113` | texto | Páginas → Footer/Sobre (texto institucional) |
| Links de partilha | `news-show.blade.php:67-90` | lista/link | Fixo |

## 11. Assistente virtual (`_assistant` e `AssistantController`)

| Conteúdo | Onde está hoje | Tipo | Onde passará a ser editado |
| --- | --- | --- | --- |
| Nome `Assistente Ceedwork` | `_assistant.blade.php:17` | texto | Config. → Assistente → nome |
| Estado `Online` | `_assistant.blade.php:18` | texto | Fixo |
| Saudação `Olá! Sou o assistente…` | `_assistant.blade.php:57` | texto | Config. → Assistente → saudação |
| 3 sugestões (chips) | `_assistant.blade.php:28-30` | lista | Config. → Assistente → sugestões |
| Nota `Respostas geradas por IA…` | `_assistant.blade.php:39` | texto | Fixo |
| Endpoint/CSRF | `_assistant.blade.php:4-5` | link | Fixo |
| Ativar/desativar assistente | não existe | booleano | Config. → Assistente → ativar |
| Prompt de sistema (empresa, missão, visão, valores, 9 serviços, 4 projetos, contactos, mapa) | `AssistantController.php:121-271` | texto/HTML | Config. → Assistente → texto extra + dados dinâmicos (Contactos, Serviços, Projetos) |
| Texto extra para o prompt (máx. 1500) | não existe | texto | Config. → Assistente → texto extra |
| Script inline do chat | `_assistant.blade.php:43-211` | código | Mover para `public/js/` |

## 12. Imagens e ativos

| Conteúdo | Onde está hoje | Tipo | Onde passará a ser editado |
| --- | --- | --- | --- |
| Banners locais (herosection, parceiros) | `app/helpers/helpers.php:14-25` | imagem | Config. → Geral/Home (upload) |
| Logótipos/marcas locais | `app/helpers/helpers.php:27-35` | imagem | Config. → Geral + CRUD `brands` |
| Redes sociais (URLs) | `app/helpers/helpers.php:37-43` | link | Config. → Redes sociais |
| Imagens Unsplash | `about`, `service`, `portfolio`, `news`, `_servicos`, `_page-header` | imagem | Upload no dashboard; reserva local |
| `placehold.co` | `_destaques.blade.php:9` | imagem | Placeholder local |
| Reservas locais | **não existem** | imagem | Criar `public/assets/images/placeholders/` |

## 13. Controladores e configuração

| Conteúdo | Onde está hoje | Tipo | Onde passará a ser editado |
| --- | --- | --- | --- |
| Assuntos do formulário | `ContactController.php:15-21` | lista | Páginas → Contactos |
| Prompt do assistente | `AssistantController.php:121-271` | texto | Config. → Assistente + BD |
| Limite de destaques da Home (5) | `HomeController.php:18` | número | Config. (opcional) |
| Chave/modelo Groq | `config/services.php:38-41` | segredo | `.env` (nunca editável no dashboard) |
| Email de destino do contacto | `ContactController.php:72` (`config('mail.from.address')`) | texto | Config. → Contactos → emails |
| Dados de `$data` (imagens/social) | `AppServiceProvider.php:21` + `helpers.php` | lista | Substituído por `SiteSettings`/`PageContent` |

---

## 14. Destinos por grupo (resumo)

### Configurações

- **Geral:** nome do site, slogan, logo, logo branco, favicon, imagem Open Graph, descrição SEO padrão.
- **Contactos:** telefones (lista), emails (geral/suporte/comercial), endereço, URL do mapa, horário, número do WhatsApp.
- **Redes sociais:** lista `rede + URL` (validação https + domínio da rede).
- **Aparência:** `primary #031b3a`, `secondary #13397c`, `accent #1baa99`, `blue #2f96bf`, `purple #475593`, `aqua #5eb3bb`, `light_blue #c3ebfa`, `background #dae1f1` (+ `accent_hover` derivado `#148577`).
- **Assistente:** ativo, nome, saudação, sugestões, texto extra (máx. 1500).

### Páginas (`page_sections`)

- **Home:** `hero`, `highlights`, `services`, `cta` (marcas e parceiros em tabelas próprias).
- **Sobre nós:** `banner`, `intro`, `images`, `mission`, `vision`, `values`, `location`.
- **Contactos:** `banner`, `intro`, `faq`, `subjects`.
- **Serviços / Portfólio / Notícias:** `header` (título, introdução, imagem do banner).
- **Footer:** `institutional`.

### Tabelas próprias

- `brands` — faixa de marcas da Home.
- `partners` — parceiros da Home.
- `contact_messages` — mensagens do formulário (Fase E).
- `activity_logs` — registo de atividade (Fase G).

---

## 15. Observações e riscos encontrados

1. **Serviços públicos ignoram o CRUD:** `pages/service.blade.php:24` reescreve `$services` com um array fixo.
2. **Portfólio público errado:** `pages/portfolio.blade.php` mostra serviços fixos e ignora `$projects`.
3. **LinkedIn da navbar aponta para o Instagram:** `_navbar.blade.php:75`.
4. **Telefone a partir de URL:** `service.blade.php:146` usa `$data['social']['whatsapp']` dentro de `tel:`; `_navbar.blade.php:62` idem.
5. **Placeholders externos:** Unsplash em 6 ficheiros e `placehold.co` em `_destaques`; não há reservas locais.
6. **Conteúdo duplicado:** contactos (telefone/email/endereço/horário) repetidos em navbar, footer, contactos, CTA e prompt do assistente.
7. **HTML sem sanitização explícita:** `{!! !!}` em `_servicos`, `news-show` e (futuro) conteúdo rich.
8. **SEO incompleto:** sem Open Graph, sem canonical, sem `theme-color`.
9. **Scripts inline:** navbar, footer, hero? (não), parceiros, destaques, contactos, notícias e assistente — candidatos a `public/js/` na Fase F / auditoria.
10. **`$data` global:** `View::share('data', site_images())` é o ponto único a substituir por `$site`/`PageContent`.

---

## 16. Critério de conclusão da migração

O site público é considerado migrado quando:

- Nenhuma view pública contém textos, imagens, contactos, cores ou links institucionais fixos (exceto rótulos de UI e estrutura de navegação).
- Com a base de dados vazia, todas as páginas renderizam com os valores de `config/site.php` (visual idêntico ao atual).
- `docs/CONTENT-MAP.md` não tem linhas com destino "fixo" para conteúdo editável.
