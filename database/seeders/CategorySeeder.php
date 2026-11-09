<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Empresa', 'slug' => 'empresa', 'description' => 'Notícias e novidades sobre a Ceedwork-Solutions.'],
            ['name' => 'Eventos', 'slug' => 'eventos', 'description' => 'Participações, encontros e iniciativas da equipa.'],
            ['name' => 'Dicas', 'slug' => 'dicas', 'description' => 'Sugestões práticas para empresas e equipas.'],
            ['name' => 'Tecnologia', 'slug' => 'tecnologia', 'description' => 'Tendências, ferramentas e soluções tecnológicas.'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
