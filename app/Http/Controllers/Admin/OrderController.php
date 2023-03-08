<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
	// Laravel: интернет магазин ч.10: Middleware Авторизации
	public function index()
	{
		// Laravel: интернет магазин ч.18: Pagination, QueryBuilder, Фильтры
		// Laravel: интернет магазин ч.20: Scope, Оптимизация запросов к БД

		$orders = Order::active()->paginate(10);
		return view('auth.orders.index', compact('orders'));
	}

	/** 
	 * Метод показа страницы заказа в админке
	 */
	public function show(Order $order)
	{
		// Laravel: интернет магазин ч.22: Кол-во товара, Soft Delete
		// Laravel: интернет магазин ч.35: Eloquent: whereHas
		$skus = $order->skus()->withTrashed()->get();
		return view('auth.orders.show', compact('order', 'skus'));
	}
}
