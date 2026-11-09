<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'name' => 'CEEDSAÚDE',
                'slug' => 'ceedsaude',
                'category' => 'Saúde',
                'summary' => 'Plataforma digital para apoiar a gestão de serviços de saúde e melhorar a experiência dos utentes.',
                'description' => 'A CEEDSAÚDE reúne informação clínica, marcações e comunicação num ambiente seguro, pensado para equipas de saúde e para quem procura cuidados.',
                'image' => 'assets/images/banners/blessed.webp',
                'technologies' => ['Laravel', 'PHP', 'MySQL', 'Tailwind CSS'],
                'url' => null,
                'sort_order' => 1,
            ],
            [
                'name' => 'Ceedschool',
                'slug' => 'ceedschool',
                'category' => 'Educação',
                'summary' => 'Sistema de gestão escolar que simplifica a comunicação entre professores, alunos e encarregados de educação.',
                'description' => 'O Ceedschool centraliza matrículas, avaliações, horários e avisos, reduzindo o trabalho administrativo e aproximando a comunidade escolar.',
                'image' => 'assets/images/banners/gracas.webp',
                'technologies' => ['Laravel', 'Vue', 'MySQL', 'Tailwind CSS'],
                'url' => null,
                'sort_order' => 2,
            ],
            [
                'name' => 'WIZA EVENTO',
                'slug' => 'wiza-evento',
                'category' => 'Eventos',
                'summary' => 'Plataforma de gestão e divulgação de eventos com inscrições, programação e acompanhamento em tempo real.',
                'description' => 'A WIZA EVENTO ajuda organizadores a publicar eventos, gerir participantes e acompanhar a adesão numa interface simples e responsiva.',
                'image' => 'assets/images/banners/reunion.avif',
                'technologies' => ['Laravel', 'Alpine.js', 'Tailwind CSS', 'MySQL'],
                'url' => null,
                'sort_order' => 3,
            ],
            [
                'name' => 'CANDONGA',
                'slug' => 'candonga',
                'category' => 'Tecnologia',
                'summary' => 'Solução digital para organizar operações, acompanhar indicadores e tomar decisões com informação atualizada.',
                'description' => 'O CANDONGA integra dados dispersos numa visão única, permitindo acompanhar processos, reduzir erros e ganhar eficiência operacional.',
                'image' => 'assets/images/banners/reunion-nacional.avif',
                'technologies' => ['Laravel', 'React', 'PostgreSQL', 'Tailwind CSS'],
                'url' => null,
                'sort_order' => 4,
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['slug' => $project['slug']],
                $project + ['is_published' => true]
            );
        }
    }
}
