<?php

namespace App\Http\Controllers;

use App\Enums\CowGender;
use App\Http\Requests\Cow\StoreRequest;
use App\Http\Requests\Cow\UpdateRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\CowResource;
use App\Models\Cow;
use App\Support\Options;
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
            'breeds'      => Options::breeds(),
            'females'     => Options::cows(CowGender::Female),
            'males'       => Options::cows(CowGender::Male),
            'aiSires'     => Options::aiSires(),
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
            'breeds'      => Options::breeds(),
            'females'     => Options::cows(CowGender::Female, $cow->id),
            'males'       => Options::cows(CowGender::Male, $cow->id),
            'aiSires'     => Options::aiSires(),
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
}
