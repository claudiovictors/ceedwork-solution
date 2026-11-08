<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(): mixed
    {
        return view('pages.news');
    }

    /** Uma notícia (/news/{slug}) */
    public function show(string $slug)
    {
        $posts = collect($this->posts());
        $index = $posts->search(fn (array $p) => $p['slug'] === $slug);

        // slug inexistente -> mostra a página 404
        abort_if($index === false, 404);

        $post = $posts[$index];

        return view('pages.news-show', [
            'post' => $post,
            'newer' => $index > 0 ? $posts[$index - 1] : null, // mais recente
            'older' => $posts[$index + 1] ?? null,              // mais antiga
            // relacionadas: primeiro as da mesma categoria
            'related' => $posts
                ->reject(fn (array $p) => $p['slug'] === $slug)
                ->sortBy(fn (array $p) => $p['category'] === $post['category'] ? 0 : 1)
                ->take(3)
                ->values(),
        ]);
    }

    /**
     * Dados de exemplo. Quando tiveres a tabela de notícias, troca isto por
     * Post::latest()->get() mantendo as mesmas chaves.
     */
    private function posts(): array
    {
        $img = fn (string $id) => "https://images.unsplash.com/photo-{$id}?auto=format&fit=crop&w=1000&q=75";

        $items = [
            [
                'title' => 'Ceedwork lança nova plataforma de gestão',
                'excerpt' => 'A Ceedwork apresentou a sua nova solução pensada para as necessidades das empresas angolanas, com foco em simplicidade e segurança.',
                'image' => $img('1522071820081-009f0129c71c'),
                'date' => '2026-07-01',
                'category' => 'Empresa',
                'tags' => ['Software', 'Gestão', 'Novidades'],
            ],
            [
                'title' => 'Presença marcante na feira de tecnologia',
                'excerpt' => 'A equipa participou na edição deste ano, partilhando casos de sucesso e novas tendências em transformação digital.',
                'image' => $img('1540575467063-178a50c2df87'),
                'date' => '2026-06-15',
                'category' => 'Eventos',
                'tags' => ['Eventos', 'Transformação digital'],
            ],
            [
                'title' => 'Nova parceria reforça infraestrutura',
                'excerpt' => 'Um novo acordo estratégico vai ampliar a capacidade de resposta e o suporte aos clientes em todo o país.',
                'image' => $img('1521737604893-d14cc237f11d'),
                'date' => '2026-05-05',
                'category' => 'Empresa',
                'tags' => ['Parcerias', 'Infraestrutura'],
            ],
            [
                'title' => 'Workshop de segurança digital',
                'excerpt' => 'Realizámos um workshop prático sobre boas práticas de cibersegurança para pequenas e médias empresas.',
                'image' => $img('1563986768609-322da13575f3'),
                'date' => '2026-04-20',
                'category' => 'Eventos',
                'tags' => ['Segurança', 'Workshop'],
            ],
            [
                'title' => 'Equipa cresce com novos talentos',
                'excerpt' => 'Damos as boas-vindas a novos profissionais que vão reforçar as áreas de desenvolvimento e suporte técnico.',
                'image' => $img('1542744173-8e7e53415bb0'),
                'date' => '2026-03-10',
                'category' => 'Empresa',
                'tags' => ['Equipa'],
            ],
            [
                'title' => 'Cinco sinais de que o seu negócio precisa de um sistema à medida',
                'excerpt' => 'Processos manuais, folhas de cálculo por todo o lado e falta de visão do negócio são alguns dos sinais de que está na hora de evoluir.',
                'image' => $img('1498050108023-c5249f4df085'),
                'date' => '2026-02-18',
                'category' => 'Dicas',
                'tags' => ['Software à medida', 'Gestão'],
            ],
            [
                'title' => 'Site institucional: por onde começar',
                'excerpt' => 'Antes de pensar no design, defina o objetivo do site, o público e os conteúdos essenciais. Veja os primeiros passos.',
                'image' => $img('1547658719-da2b51169166'),
                'date' => '2026-01-27',
                'category' => 'Dicas',
                'tags' => ['Web', 'Site institucional'],
            ],
            [
                'title' => 'Aplicativo nativo ou híbrido? Como escolher',
                'excerpt' => 'Entenda as diferenças entre as duas abordagens e o que deve pesar na decisão: orçamento, prazo e experiência do utilizador.',
                'image' => $img('1512941937669-90a1b58e7e9c'),
                'date' => '2025-12-12',
                'category' => 'Tecnologia',
                'tags' => ['Mobile', 'Flutter', 'React Native'],
            ],
            [
                'title' => 'Porque a segurança dos dados importa para as empresas',
                'excerpt' => 'Backups, acessos controlados e boas práticas simples ajudam a proteger a informação do seu negócio.',
                'image' => $img('1558494949-ef010cbdcc31'),
                'date' => '2025-11-04',
                'category' => 'Tecnologia',
                'tags' => ['Segurança', 'Dados'],
            ],
        ];

        return array_map(function (array $item) use ($img) {
            $item['slug'] = Str::slug($item['title']);
            $item['author'] = ['name' => 'Ceedwork-Solutions', 'role' => 'Equipa Ceedwork'];
            $item['body'] = $item['body'] ?? $this->sampleBody($item['excerpt'], $img('1498050108023-c5249f4df085'));

            return $item;
        }, $items);
    }

    /** Texto de exemplo em HTML (substitui pelo conteúdo real de cada notícia). */
    private function sampleBody(string $excerpt, string $image): string
    {
        return <<<HTML
        <p class="lead">{$excerpt}</p>
        <p>Este é um texto de exemplo para mostrar como a página de uma notícia fica com conteúdo real. Substitua-o pelo texto da notícia, escrito em HTML simples: parágrafos, títulos, listas, imagens e citações.</p>
        <h2>Um subtítulo para organizar o texto</h2>
        <p>Parágrafos curtos, com frases diretas, são mais fáceis de ler no ecrã. Use subtítulos para dividir o assunto em partes e <a href="/contacts">links</a> para levar o leitor a outras páginas do site.</p>
        <ul>
            <li>Primeiro ponto da lista</li>
            <li>Segundo ponto da lista</li>
            <li>Terceiro ponto da lista</li>
        </ul>
        <figure>
            <img src="{$image}" alt="Imagem de exemplo no meio do texto" loading="lazy">
            <figcaption>Legenda da imagem de exemplo.</figcaption>
        </figure>
        <blockquote>
            <p>Uma citação em destaque ajuda a chamar a atenção para a ideia principal do texto.</p>
        </blockquote>
        <h3>Outro subtítulo, mais pequeno</h3>
        <p>Para terminar, mais um parágrafo de exemplo. Quando as notícias vierem da base de dados, este conteúdo passa a ser escrito no painel de administração.</p>
        HTML;
    }
}
