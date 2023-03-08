<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkuRequest;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Laravel: интернет магазин ч.34: Plural & Singular

class SkuController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @param  Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function index(Product $product)
	{
		// получим все товарные предложения конкретного продукта (по 10-ть на странице)
		$skus = $product->skus()->paginate(10);
		return view('auth.skus.index', compact('skus', 'product'));
	}

	/**
	 * Метод реализует добавление товарного предложения
	 *
	 * @param  Product  $product
	 * @return void
	 */
	public function create(Product $product)
	{
		// admin/products/{product}/skus/create
		return view('auth.skus.form', compact('product'));
	}

	/**
	 * Метод сохраняет данные полученные из формы
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  Product  $product
	 * @return void
	 */
	public function store(SkuRequest $request, Product $product)
	{
		$params = $request->all();
		$params['product_id'] = $request->product->id;

		$skus = Sku::create($params);
		$skus->propertyOptions()->sync($request->property_id);

		//admin/products/{product}/skus

		return redirect()->route('skus.index', $product);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Product  $product
	 * @param  Sku  $skus
	 * @return void
	 */
	public function show(Product $product, Sku $sku)
	{
		//dd($sku);

		// admin/products/{product}/skus/{sku}

		return view('auth.skus.show', compact('product', 'sku'));
	}

	/**
	 * Показать форму для редактирования товарного предложения
	 *
	 * @param  Product  $product
	 * @param  Sku  $skus
	 * @return void
	 */
	public function edit(Product $product, Sku $sku)
	{
		//dd($sku);

		// admin/products/{product}/skus/{sku}/edit

		return view('auth.skus.form', compact('product', 'sku'));
	}

	/**
	 * Редактирование и сохранение товарных предложений
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  Product  $product
	 * @param  Sku  $skus
	 * @return void
	 */
	public function update(Request $request, Product $product, Sku $sku)
	{
		//dd($sku);
		$params = $request->all();
		$params['product_id'] = $request->product->id;
		$sku->update($params);
		$sku->propertyOptions()->sync($request->property_id);
		return redirect()->route('skus.index', $product);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  Product  $product
	 * @param  Sku  $skus
	 * @return void
	 * @throws \Exception
	 */
	public function destroy(Product $product, Sku $sku)
	{
		//dd($sku);
		$sku->delete();
		return redirect()->route('skus.index', $product);
	}
}
