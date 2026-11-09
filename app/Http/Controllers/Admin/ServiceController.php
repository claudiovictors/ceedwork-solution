<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServiceRequest;
use App\Http\Requests\Admin\UpdateServiceRequest;
use App\Models\Service;
use App\Support\ImageUploader;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function __construct(
        private readonly ImageUploader $uploader,
    ) {}

    /**
     * Lista os serviços.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $services = Service::query()
            ->withCount('items')
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('summary', 'like', "%{$search}%");
                });
            })
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('admin.services.index', [
            'services' => $services,
            'search' => $search,
        ]);
    }

    /**
     * Exibe o formulário de criação de um serviço.
     */
    public function create(): View
    {
        return view('admin.services.create', [
            'service' => new Service([
                'is_active' => true,
                'sort_order' => 0,
            ]),
        ]);
    }

    /**
     * Guarda um novo serviço.
     */
    public function store(StoreServiceRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $items = $data['items'];
        unset($data['items'], $data['remove_image']);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploader->store($request->file('image'), 'services');
        }

        DB::transaction(function () use ($data, $items): void {
            $service = Service::create($data);

            $this->createItems($service, $items);
        });

        return redirect()
            ->route('admin.services.index')
            ->with('status', 'Serviço criado com sucesso.');
    }

    /**
     * Exibe o formulário de edição de um serviço.
     */
    public function edit(Service $service): View
    {
        $service->load('items');

        return view('admin.services.edit', [
            'service' => $service,
        ]);
    }

    /**
     * Atualiza um serviço existente.
     */
    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        $data = $request->validated();
        $items = $data['items'];
        unset($data['items'], $data['remove_image']);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $this->uploader->delete($service->image);
            $data['image'] = $this->uploader->store($request->file('image'), 'services');
        } elseif ($request->boolean('remove_image')) {
            $this->uploader->delete($service->image);
            $data['image'] = null;
        } else {
            unset($data['image']);
        }

        DB::transaction(function () use ($service, $data, $items): void {
            $service->update($data);
            $service->items()->delete();

            $this->createItems($service, $items);
        });

        return redirect()
            ->route('admin.services.index')
            ->with('status', 'Serviço atualizado com sucesso.');
    }

    /**
     * Remove um serviço e respetivos itens.
     */
    public function destroy(Service $service): RedirectResponse
    {
        $this->uploader->delete($service->image);
        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('status', 'Serviço eliminado com sucesso.');
    }

    /**
     * Ativa ou desativa um serviço.
     */
    public function toggleActive(Service $service): RedirectResponse
    {
        $service->update(['is_active' => ! $service->is_active]);

        return back()->with(
            'status',
            $service->is_active
                ? 'Serviço ativado com sucesso.'
                : 'Serviço desativado com sucesso.'
        );
    }

    /**
     * @param  array<int, string>  $items
     */
    private function createItems(Service $service, array $items): void
    {
        foreach (array_values($items) as $index => $title) {
            $service->items()->create([
                'title' => $title,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
