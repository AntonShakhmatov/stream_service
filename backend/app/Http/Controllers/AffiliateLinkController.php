<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAffiliateLinkRequest;
use App\Http\Requests\UpdateAffiliateLinkRequest;
use App\Models\AffiliateLink;
use App\Models\Model;
use App\Models\Stream;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class AffiliateLinkController extends Controller
{
    /**
     * Отображение списка ссылок с фильтрацией и пагинацией
     */
    public function index(Request $request)
    {
        $links = QueryBuilder::for(AffiliateLink::class)
            ->allowedFilters([
                'platform', // Фильтрация по платформе
            ])
            ->defaultSort('id')
            ->allowedSorts(['id', 'platform', 'url'])
            ->paginate($request->get('perPage', 10))
            ->withQueryString();

        return Inertia::render('AffiliateLinks/Index', [
            'links' => $links,
        ]);
    }

    /**
     * Отображение формы создания
     */
    public function create()
    {
        return Inertia::render('AffiliateLinks/CreateForm');
    }

    /**
     * Создание новой ссылки
     */
    public function store(StoreAffiliateLinkRequest $request)
    {
        $validated = $request->validated();

        // Проверка наличия записи по платформе
        $affiliateLink = AffiliateLink::where('platform', $validated['platform'])->first();

        if ($affiliateLink) {
            // Если запись найдена, обновляем URL
            $affiliateLink->update(['url' => $validated['url']]);
        } else {

            AffiliateLink::create([
                'platform' => $validated['platform'],
                'url' => $validated['url'],
            ]);
        }
        return redirect()->route('aff.index')->with('message', 'Affiliate link created successfully.');
    }

    /**
     * Отображение формы редактирования
     */
    public function edit(AffiliateLink $affiliateLink)
    {
        $streams = AffiliateLink::query()->pluck('id', 'platform', 'url'); // Список доступных стримов

        return Inertia::render('AffiliateLinks/EditForm', [
            'link' => $affiliateLink,
        ]);
    }

    /**
     * Обновление ссылки
     */
    public function update(Request $request, AffiliateLink $affiliateLink)
    {
        $validated = $request->validated();

        $affiliateLink->update(['url' => $validated['url']]);

        return redirect()->route('aff.index')->with('message', 'Affiliate link updated successfully.');
    }


    /**
     * Удаление ссылки
     */
    public function destroy(AffiliateLink $affiliateLink)
    {
        $affiliateLink->delete();

        return redirect()->route('aff.index')->with('message', 'Affiliate link deleted successfully.');
    }
}
