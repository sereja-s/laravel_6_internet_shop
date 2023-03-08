<?php

namespace App\ViewComposers;

use App\Models\Order;
use App\Models\Sku;
use Illuminate\View\View;

// Laravel: интернет магазин ч.31: ViewComposer, Collection (map, flatten, take, mapToGroups)

/** 
 * Класс добавляет самые популярные товары (по кол-ву покупок)
 */
class BestProductsComposer
{
	public function compose(View $view)
	{
		// Laravel: интернет магазин ч.35: Eloquent: whereHas
		$bestSkuIds = Order::get()->map->skus->flatten()->map->pivot->mapToGroups(function ($pivot) {
			return [$pivot->sku_id => $pivot->count];
		})->map->sum()->sortByDesc(null)->take(3)->keys()->toArray();

		$bestSkus = Sku::whereIn('id', $bestSkuIds)->get();
		$view->with('bestSkus', $bestSkus);
	}
}
