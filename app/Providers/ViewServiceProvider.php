<?php

namespace App\Providers;

use App\Services\CurrencyConversion;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

// Laravel: интернет магазин ч.31: ViewComposer, Collection (map, flatten, take, mapToGroups)

class ViewServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// добавим категории для всех страниц в указанных шаблонах
		View::composer(['layouts.master', 'categories'], 'App\ViewComposers\CategoriesComposer');

		// Laravel: интернет магазин ч.38: Функционал купонов - админка
		View::composer(['layouts.master', 'auth.coupons.form'], 'App\ViewComposers\CurrenciesComposer');
		View::composer(['layouts.master'], 'App\ViewComposers\BestProductsComposer');

		// для всех шаблонов
		View::composer('*', function ($view) {
			$currencySymbol = CurrencyConversion::getCurrencySymbol();
			$view->with('currencySymbol', $currencySymbol);
		});
	}
}
