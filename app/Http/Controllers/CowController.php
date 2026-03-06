<?php

namespace App\Http\Controllers;

use App\Enums\CowGender;
use App\Http\Requests\Cow\StoreRequest;
use App\Models\AiSire;
use App\Http\Requests\Cow\UpdateRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\CowResource;
use App\Models\Cow;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CowController extends Controller
{
    public function index(SearchRequest $request): Response
    {
        $params = [
            'search' => $request->search,
        ];

        $cows = CowResource::collection(Cow::search($params)
            ->paginate()->withQueryString());

        $breadcrumbs = [
            ['label' => 'Cows', 'url' => ''],
        ];

        return Inertia::render('Cow/Index', [
            'search'      => $request->search,
            'cows'        => $cows,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function create(): Response
    {
        $breadcrumbs = [
            ['label' => 'Cows', 'url' => route('cows.index')],
            ['label' => 'Add New Cow', 'url' => ''],
        ];

        return Inertia::render('Cow/Create', [
            'breadcrumbs' => $breadcrumbs,
            'females'     => $this->cowOptions(CowGender::Female),
            'males'       => $this->cowOptions(CowGender::Male),
            'aiSires'     => $this->aiSireOptions(),
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        Cow::create($request->validated());

        return redirect()->route('cows.index')->with('success', 'Cow added successfully.');
    }

    public function edit(Cow $cow): Response
    {
        $breadcrumbs = [
            ['label' => 'Cows', 'url' => route('cows.index')],
            ['label' => 'Edit Cow', 'url' => ''],
        ];

        return Inertia::render('Cow/Edit', [
            'breadcrumbs' => $breadcrumbs,
            'cow'         => new CowResource($cow),
            'females'     => $this->cowOptions(CowGender::Female, $cow->id),
            'males'       => $this->cowOptions(CowGender::Male, $cow->id),
            'aiSires'     => $this->aiSireOptions(),
        ]);
    }

    public function update(UpdateRequest $request, Cow $cow): RedirectResponse
    {
        $cow->update($request->validated());

        return redirect()->route('cows.index')->with('success', 'Cow updated successfully.');
    }

    public function destroy(Cow $cow): RedirectResponse
    {
        $cow->delete();

        return redirect()->route('cows.index')->with('success', 'Cow deleted successfully.');
    }

    private function aiSireOptions(): array
    {
        return AiSire::orderBy('bull_id')
            ->get()
            ->map(fn($s) => ['value' => $s->id, 'name' => $s->bull_id . ($s->name ? ' — ' . $s->name : '')])
            ->toArray();
    }

    private function cowOptions(CowGender $gender, ?int $excludeId = null): array
    {
        return Cow::where('gender', $gender->value)
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->orderBy('cow_id')
            ->get()
            ->map(fn($c) => ['value' => $c->id, 'name' => $c->cow_id . ($c->name ? ' — ' . $c->name : '')])
            ->toArray();
    }
}
