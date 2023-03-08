<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsFilterRequest;
use App\Http\Requests\SubscriptionRequest;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Product;
use App\Models\Sku;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class MainController extends Controller
{
	public function index(ProductsFilterRequest $request)
	{
		// Laravel: интернет магазин ч.19: Log, Debugbar, Eager Load

		$skusQuery = Sku::with(['product', 'product.category']);

		// Laravel: интернет магазин ч.18: Pagination, QueryBuilder, Фильтры

		if ($request->filled('price_from')) {
			$skusQuery->where('price', '>=', $request->price_from);
		}

		if ($request->filled('price_to')) {
			$skusQuery->where('price', '<=', $request->price_to);
		}

		// Laravel: интернет магазин +ч.20: Scope, Оптимизация запросов к БД
		foreach (['hit', 'new', 'recommend'] as $field) {
			if ($request->has($field)) {
				$skusQuery->whereHas('product', function ($query) use ($field) {
					$query->$field();
				});
			}
		}

		$skus = $skusQuery->paginate(6)->withPath("?" . $request->getQueryString());

		return view('index', compact('skus'));
	}

	// Laravel: интернет магазин ч.31: ViewComposer, Collection (map, flatten, take, mapToGroups)
	public function categories()
	{
		return view('categories');
	}

	public function category($code)
	{
		$category = Category::where('code', $code)->first();
		return view('category', compact('category'));
	}

	public function sku($categoryCode, $productCode, Sku $skus)
	{
		if ($skus->product->code != $productCode) {
			abort(404, 'Product not found');
		}

		if ($skus->product->category->code != $categoryCode) {
			abort(404, 'Category not found');
		}

		return view('product', compact('skus'));
	}

	// Laravel: интернет магазин ч.25: Observer (подписка на отсутствующий товар)

	public function subscribe(SubscriptionRequest $request, Sku $skus)
	{
		Subscription::create([
			'email' => $request->email,
			'sku_id' => $skus->id,
		]);

		return redirect()->back()->with('success', __('product.we_will_update'));
	}

	// Laravel: интернет магазин ч.26: Localization - Мультиязычность
	public function changeLocale($locale)
	{
		$availableLocales = ['ru', 'en'];
		if (!in_array($locale, $availableLocales)) {
			$locale = config('app.locale');
		}
		session(['locale' => $locale]);
		App::setLocale($locale);
		return redirect()->back();
	}

	// Laravel: интернет магазин ч.28: Мультивалюта
	public function changeCurrency($currencyCode)
	{
		$currency = Currency::byCode($currencyCode)->firstOrFail();
		session(['currency' => $currency->code]);
		return redirect()->back();
	}
}
