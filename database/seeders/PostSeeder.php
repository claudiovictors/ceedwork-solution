<?php

namespace Database\Seeders;

use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::pluck('id', 'slug');
        $authorId = User::where('is_admin', true)->value('id');

        $posts = [
            [
                'slug' => 'transformacao-digital-nas-empresas-angolanas',
                'title' => 'Demonstração: Transformação digital nas empresas angolanas',
                'category' => 'tecnologia',
                'excerpt' => 'Como a tecnologia pode ajudar as empresas a ganhar eficiência, melhorar o atendimento e crescer com segurança.',
                'cover_image' => 'assets/images/banners/reunion.avif',
                'is_featured' => true,
                'status' => PostStatus::Published,
                'published_at' => now()->subDays(2),
            ],
            [
                'slug' => 'como-escolher-a-tecnologia-certa',
                'title' => 'Demonstração: Como escolher a tecnologia certa para o seu projeto',
                'category' => 'dicas',
                'excerpt' => 'Perguntas essenciais antes de decidir entre uma solução pronta, uma aplicação à medida ou uma plataforma híbrida.',
                'cover_image' => 'assets/images/banners/chat.avif',
                'is_featured' => false,
                'status' => PostStatus::Published,
                'published_at' => now()->subDays(5),
            ],
            [
                'slug' => 'ceedwork-apoia-evento-de-inovacao',
                'title' => 'Demonstração: Ceedwork-Solutions apoia evento de inovação',
                'category' => 'eventos',
                'excerpt' => 'A equipa esteve presente num encontro dedicado à tecnologia, empreendedorismo e partilha de conhecimento.',
                'cover_image' => 'assets/images/banners/reunion-nacional.avif',
                'is_featured' => false,
                'status' => PostStatus::Published,
                'published_at' => now()->subDays(10),
            ],
            [
                'slug' => 'sinais-de-que-a-sua-empresa-precisa-de-um-novo-website',
                'title' => 'Demonstração: 5 sinais de que a sua empresa precisa de um novo website',
                'category' => 'empresa',
                'excerpt' => 'Um website desatualizado pode afastar clientes. Estes sinais ajudam a perceber quando é hora de renovar.',
                'cover_image' => 'assets/images/banners/herosection.png',
                'is_featured' => false,
                'status' => PostStatus::Published,
                'published_at' => now()->subDays(15),
            ],
            [
                'slug' => 'seguranca-em-aplicacoes-web',
                'title' => 'Demonstração: Segurança em aplicações web',
                'category' => 'tecnologia',
                'excerpt' => 'Boas práticas para proteger dados, controlar acessos e reduzir riscos nas aplicações do dia a dia.',
                'cover_image' => 'assets/images/banners/kuma.png',
                'is_featured' => false,
                'status' => PostStatus::Published,
                'published_at' => now()->subDays(20),
            ],
            [
                'slug' => 'rascunho-novidades-da-plataforma',
                'title' => 'Demonstração: Rascunho — novidades da plataforma',
                'category' => 'empresa',
                'excerpt' => 'Este conteúdo é um rascunho de demonstração e não deve aparecer no website público.',
                'cover_image' => null,
                'is_featured' => false,
                'status' => PostStatus::Draft,
                'published_at' => null,
            ],
            [
                'slug' => 'artigo-agendado-de-demonstracao',
                'title' => 'Demonstração: Artigo agendado',
                'category' => 'tecnologia',
                'excerpt' => 'Este artigo está marcado como publicado, mas só deve ser visível após a data de publicação.',
                'cover_image' => null,
                'is_featured' => false,
                'status' => PostStatus::Published,
                'published_at' => now()->addDays(5),
            ],
        ];

        foreach ($posts as $post) {
            Post::updateOrCreate(
                ['slug' => $post['slug']],
                [
                    'category_id' => $categories[$post['category']],
                    'author_id' => $authorId,
                    'title' => $post['title'],
                    'excerpt' => $post['excerpt'],
                    'body' => $this->body($post['title']),
                    'cover_image' => $post['cover_image'],
                    'status' => $post['status'],
                    'is_featured' => $post['is_featured'],
                    'published_at' => $post['published_at'],
                ]
            );
        }
    }

    private function body(string $title): string
    {
        return <<<HTML
        <p>Este é um conteúdo de demonstração criado para validar a nova área de notícias da Ceedwork-Solutions.</p>
        <h2>Sobre este artigo</h2>
        <p>{$title} reúne informação de exemplo que pode ser substituída através do painel administrativo.</p>
        <ul>
            <li>Conteúdo editável com formatação rica.</li>
            <li>Imagens de capa e imagens no corpo do texto.</li>
            <li>Publicação controlada por estado e data.</li>
        </ul>
        <blockquote>Este texto não representa uma notícia real.</blockquote>
        HTML;
    }
}
