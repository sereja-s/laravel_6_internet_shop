<?php

namespace App\Providers;

use App\Models\Product;
use App\Observers\ProductObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		// Laravel: интернет магазин ч.21: Деплой на хостинг Timeweb
		Schema::defaultStringLength(191);
	}

	// Laravel: интернет магазин ч.15: Blade Custom Directive
	/**	 
	 * 
	 * Допишем свои расширения для Blade, чтобы использовать их в шаблоне
	 *
	 * @return void
	 */
	public function boot()
	{
		// расширение для шаблона: layouts/master (название одним словом)
		Blade::directive('routeactive', function ($route) {
			// в скомпилированном шаблоне в storage/framework/views будет подставляться: 
			return "<?php echo Route::currentRouteNamed($route) ? 'class=\"active\"' : '' ?>";
		});

		// сформируем кастомный if, что бы в шаблонах проверять, авторизован ли пользователь и является ли он администратором (ч.15)
		Blade::if('admin', function () {
			return Auth::check() && Auth::user()->isAdmin();
		});

		// Laravel: интернет магазин ч.25: Observer (подписка на отсутствующий товар)
		Product::observe(ProductObserver::class);
	}
}
