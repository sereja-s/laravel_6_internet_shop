<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
	public function index()
	{
		// получим заказы, которые принадлежат пользователю (ч.15)
		// Laravel: интернет магазин ч.18: Pagination, QueryBuilder, Фильтры
		// Laravel: интернет магазин ч.20: Scope, Оптимизация запросов к БД

		$orders = Auth::user()->orders()->active()->paginate(10);
		return view('auth.orders.index', compact('orders'));
	}

	public function show(Order $order)
	{
		// проверим что заказ принадлежит данному пользователю (ч.15)
		if (!Auth::user()->orders->contains($order)) {
			return back();
		}

		return view('auth.orders.show', compact('order'));
	}
}
