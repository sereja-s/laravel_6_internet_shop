<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
	// Laravel: интернет магазин ч.10: Middleware Авторизации
	public function index()
	{
		$orders = Order::active()->paginate(10);
		return view('auth.orders.index', compact('orders'));
	}

	/** 
	 * Метод показа страницы заказа в админке
	 */
	public function show(Order $order)
	{
		$skus = $order->skus()->withTrashed()->get();
		return view('auth.orders.show', compact('order', 'skus'));
	}
}
