<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFavoriteModelsRequest;
use App\Http\Requests\UpdateFavoriteModelsRequest;
use App\Models\FavoriteModels;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class FavoriteModelsController extends Controller
{
    /**
     * Отображение списка ссылок с фильтрацией и пагинацией
     */
    public function index(Request $request)
    {
        $links = QueryBuilder::for(FavoriteModels::class)
            ->allowedFilters([
                'username', // Фильтрация по платформе
            ])
            ->defaultSort('id')
            ->allowedSorts(['id', 'username'])
            ->paginate($request->get('perPage', 10))
            ->withQueryString();

        return Inertia::render('FavoriteModels/Index', [
            'links' => $links->items(),
        ]);
    }

    /**
     * Отображение формы создания
     */
    public function create()
    {
        return Inertia::render('FavoriteModels/Index');
    }

    public function store(StoreFavoriteModelsRequest $request)
    {
        $favoriteModel = FavoriteModels::create($request->validated());
        return back()->with(['id' => $favoriteModel->id]);
    }

    public function update(UpdateFavoriteModelsRequest $request, $id)
    {
        $favoriteModel = FavoriteModels::findOrFail($id);
        $favoriteModel->update($request->validated());

        return redirect()->route('favorite.index')->with('message', $favoriteModel->username);
    }
}
