<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

// Laravel: интернет магазин ч.26: Localization - Мультиязычность

class SetLocale
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$locale = session('locale');
		App::setLocale($locale);
		return $next($request);
	}
}
