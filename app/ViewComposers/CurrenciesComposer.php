<?php

namespace App\ViewComposers;

use App\Services\CurrencyConversion;
use Illuminate\View\View;

// Laravel: интернет магазин ч.31: ViewComposer, Collection (map, flatten, take, mapToGroups)

class CurrenciesComposer
{
	public function compose(View $view)
	{
		$currencies = CurrencyConversion::getCurrencies();
		$view->with('currencies', $currencies);
	}
}
