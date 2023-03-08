<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		// Laravel: интернет магазин ч.18: Pagination, QueryBuilder, Фильтры

		$products = Product::paginate(10);
		return view('auth.products.index', compact('products'));
	}

	// Laravel: интернет магазин ч.13: Storage
	/**
	 * Метод создания товара
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$categories = Category::get();

		// Laravel: интернет магазин ч.34: Plural & Singular
		$properties = Property::get();
		return view('auth.products.form', compact('categories', 'properties'));
	}

	// Laravel: интернет магазин ч.13: Storage
	/**
	 * Метод сохраняет товар
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(ProductRequest $request)
	{
		$params = $request->all();

		unset($params['image']);
		if ($request->has('image')) {
			$params['image'] = $request->file('image')->store('products');
		}

		Product::create($params);
		return redirect()->route('products.index');
	}

	/**
	 * Метод показывает товар
	 *
	 * @param  \App\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function show(Product $product)
	{
		return view('auth.products.show', compact('product'));
	}

	/**
	 * Метод показывает страницу формы редактирования товара
	 *
	 * @param  \App\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Product $product)
	{
		$categories = Category::get();

		// Laravel: интернет магазин ч.34: Plural & Singular
		$properties = Property::get();
		return view('auth.products.form', compact('product', 'categories', 'properties'));
	}

	// Laravel: интернет магазин ч.13: Storage
	/**
	 * Метод для редактирования товаров
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function update(ProductRequest $request, Product $product)
	{
		$params = $request->all();
		unset($params['image']);
		if ($request->has('image')) {
			Storage::delete($product->image);
			$params['image'] = $request->file('image')->store('products');
		}

		// Laravel: интернет магазин ч.17: Checkbox, Mutator
		foreach (['new', 'hit', 'recommend'] as $fieldName) {
			if (!isset($params[$fieldName])) {
				$params[$fieldName] = 0;
			}
		}

		//dd($request->property_id);

		// Laravel: интернет магазин ч.34: Plural & Singular
		// синхронизируем то, что у нас есть с тем что пришло
		$product->properties()->sync($request->property_id);

		$product->update($params);
		return redirect()->route('products.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Product $product)
	{
		$product->delete();
		return redirect()->route('products.index');
	}
}
