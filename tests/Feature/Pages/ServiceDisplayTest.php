<?php

namespace Tests\Feature\Pages;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ServiceDisplayTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();
    }

    public function test_services_page_lists_active_services_from_the_database(): void
    {
        $service = Service::factory()->create([
            'title' => 'Serviço de Teste',
            'slug' => 'servico-de-teste',
            'icon' => 'bx bx-code-alt',
            'summary' => 'Resumo do serviço de teste.',
            'sort_order' => 1,
        ]);

        $service->items()->create([
            'title' => 'Item do serviço de teste',
            'sort_order' => 1,
        ]);

        Service::factory()->inactive()->create([
            'title' => 'Serviço Inativo',
            'slug' => 'servico-inativo',
        ]);

        $this->get(route('services'))
            ->assertOk()
            ->assertSee('Serviço de Teste')
            ->assertSee('Resumo do serviço de teste.')
            ->assertSee('Item do serviço de teste')
            ->assertSee('id="servico-de-teste"', false)
            ->assertDontSee('Serviço Inativo');
    }

    public function test_services_page_renders_without_services(): void
    {
        $this->get(route('services'))
            ->assertOk()
            ->assertSee('Serviços');
    }
}
