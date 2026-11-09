<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Desenvolvimento de Software',
                'slug' => 'desenvolvimento-de-software',
                'icon' => 'bx bx-code-alt',
                'summary' => 'Soluções digitais à medida para automatizar processos, organizar informação e apoiar o crescimento do seu negócio.',
                'image' => 'assets/images/banners/blessed.webp',
                'items' => [
                    'Websites e aplicações web',
                    'Sistemas de gestão',
                    'APIs e integrações',
                    'Manutenção e evolução',
                ],
            ],
            [
                'title' => 'Desenvolvimento Mobile',
                'slug' => 'desenvolvimento-mobile',
                'icon' => 'bx bx-mobile-alt',
                'summary' => 'Aplicações móveis rápidas e intuitivas para aproximar a sua empresa dos clientes em qualquer lugar.',
                'image' => 'assets/images/banners/gracas.webp',
                'items' => [
                    'Aplicações Android e iOS',
                    'Aplicações híbridas',
                    'Integração com APIs',
                    'Publicação nas lojas',
                ],
            ],
            [
                'title' => 'Websites',
                'slug' => 'websites',
                'icon' => 'bx bx-globe',
                'summary' => 'Presença digital profissional, responsiva e preparada para comunicar com clareza e gerar novas oportunidades.',
                'image' => 'assets/images/banners/reunion.avif',
                'items' => [
                    'Sites institucionais',
                    'Landing pages',
                    'Lojas online',
                    'Otimização para motores de busca',
                ],
            ],
        ];

        DB::transaction(function () use ($services): void {
            foreach ($services as $index => $data) {
                $service = Service::updateOrCreate(
                    ['slug' => $data['slug']],
                    [
                        'title' => $data['title'],
                        'icon' => $data['icon'],
                        'summary' => $data['summary'],
                        'image' => $data['image'],
                        'is_active' => true,
                        'sort_order' => $index + 1,
                    ]
                );

                $service->items()->delete();

                foreach ($data['items'] as $itemIndex => $item) {
                    $service->items()->create([
                        'title' => $item,
                        'sort_order' => $itemIndex + 1,
                    ]);
                }
            }
        });
    }
}
