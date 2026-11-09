<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use App\Models\Project;
use App\Support\ImageUploader;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function __construct(
        private readonly ImageUploader $uploader,
    ) {}

    /**
     * Lista os projetos do portfólio.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $category = trim((string) $request->query('category', ''));

        $projects = Project::query()
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('summary', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%");
                });
            })
            ->when($category !== '', fn (Builder $query) => $query->where('category', $category))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('admin.portfolio.index', [
            'projects' => $projects,
            'categories' => $this->categories(),
            'search' => $search,
            'selectedCategory' => $category,
        ]);
    }

    /**
     * Exibe o formulário de criação de um projeto.
     */
    public function create(): View
    {
        return view('admin.portfolio.create', [
            'project' => new Project([
                'is_published' => true,
                'sort_order' => 0,
                'technologies' => [],
            ]),
            'categories' => $this->categories(),
        ]);
    }

    /**
     * Guarda um novo projeto.
     */
    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $data = $request->validated();
        unset($data['remove_logo'], $data['remove_image']);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->uploader->store($request->file('logo'), 'projects/logos');
        }

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploader->store($request->file('image'), 'projects/images');
        }

        Project::create($data);

        return redirect()
            ->route('admin.portfolio.index')
            ->with('status', 'Projeto criado com sucesso.');
    }

    /**
     * Exibe o formulário de edição de um projeto.
     */
    public function edit(Project $project): View
    {
        return view('admin.portfolio.edit', [
            'project' => $project,
            'categories' => $this->categories(),
        ]);
    }

    /**
     * Atualiza um projeto existente.
     */
    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $data = $request->validated();
        unset($data['remove_logo'], $data['remove_image']);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('logo')) {
            $this->uploader->delete($project->logo);
            $data['logo'] = $this->uploader->store($request->file('logo'), 'projects/logos');
        } elseif ($request->boolean('remove_logo')) {
            $this->uploader->delete($project->logo);
            $data['logo'] = null;
        } else {
            unset($data['logo']);
        }

        if ($request->hasFile('image')) {
            $this->uploader->delete($project->image);
            $data['image'] = $this->uploader->store($request->file('image'), 'projects/images');
        } elseif ($request->boolean('remove_image')) {
            $this->uploader->delete($project->image);
            $data['image'] = null;
        } else {
            unset($data['image']);
        }

        $project->update($data);

        return redirect()
            ->route('admin.portfolio.index')
            ->with('status', 'Projeto atualizado com sucesso.');
    }

    /**
     * Remove um projeto.
     */
    public function destroy(Project $project): RedirectResponse
    {
        $this->uploader->delete($project->logo);
        $this->uploader->delete($project->image);
        $project->delete();

        return redirect()
            ->route('admin.portfolio.index')
            ->with('status', 'Projeto eliminado com sucesso.');
    }

    /**
     * Publica ou despublica um projeto.
     */
    public function togglePublished(Project $project): RedirectResponse
    {
        $project->update(['is_published' => ! $project->is_published]);

        return back()->with(
            'status',
            $project->is_published
                ? 'Projeto publicado com sucesso.'
                : 'Projeto despublicado com sucesso.'
        );
    }

    /**
     * @return array<int, string>
     */
    private function categories(): array
    {
        return Project::query()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->all();
    }
}
