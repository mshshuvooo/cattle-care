<?php

namespace App\Http\Controllers;

use App\Http\Requests\AiSire\StoreRequest;
use App\Http\Requests\AiSire\UpdateRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\AiSireResource;
use App\Models\AiSire;
use App\Support\Options;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AiSireController extends Controller
{
    public function index(SearchRequest $request): Response
    {
        $params = [
            'search' => $request->search,
        ];

        $aiSires = AiSireResource::collection(AiSire::search($params)
            ->paginate()->withQueryString());

        $breadcrumbs = [
            ['label' => 'AI Sires', 'url' => ''],
        ];

        return Inertia::render('AiSire/Index', [
            'search'      => $request->search,
            'aiSires'     => $aiSires,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function create(): Response
    {
        $breadcrumbs = [
            ['label' => 'AI Sires', 'url' => route('ai-sires.index')],
            ['label' => 'Add New AI Sire', 'url' => ''],
        ];

        return Inertia::render('AiSire/Create', [
            'breadcrumbs' => $breadcrumbs,
            'breeds'      => Options::breeds(),
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        AiSire::create($request->validated());

        return redirect()->route('ai-sires.index')->with('success', 'AI Sire added successfully.');
    }

    public function edit(AiSire $aiSire): Response
    {
        $breadcrumbs = [
            ['label' => 'AI Sires', 'url' => route('ai-sires.index')],
            ['label' => 'Edit AI Sire', 'url' => ''],
        ];

        return Inertia::render('AiSire/Edit', [
            'breadcrumbs' => $breadcrumbs,
            'aiSire'      => new AiSireResource($aiSire),
            'breeds'      => Options::breeds(),
        ]);
    }

    public function update(UpdateRequest $request, AiSire $aiSire): RedirectResponse
    {
        $aiSire->update($request->validated());

        return redirect()->route('ai-sires.index')->with('success', 'AI Sire updated successfully.');
    }

    public function destroy(AiSire $aiSire): RedirectResponse
    {
        $aiSire->delete();

        return redirect()->route('ai-sires.index')->with('success', 'AI Sire deleted successfully.');
    }
}
