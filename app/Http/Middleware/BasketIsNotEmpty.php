<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;

// Laravel: интернет магазин ч.11: Создание Middleware, Auth

class BasketIsNotEmpty
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
		$order = session('order');

		if (!is_null($order) && $order->getFullSum() > 0) {
			return $next($request);
		}

		session()->forget('order');
		session()->flash('warning', __('basket.cart_is_empty'));
		return redirect()->route('index');
	}
}
