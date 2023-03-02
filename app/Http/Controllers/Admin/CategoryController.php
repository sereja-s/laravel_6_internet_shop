<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Laravel: интернет магазин ч.12: Resource Controller, REST, Spoofing

class CategoryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		// Laravel: интернет магазин ч.18: Pagination, QueryBuilder, Фильтры

		$categories = Category::paginate(10);
		return view('auth.categories.index', compact('categories'));
	}

	/**
	 * Метод создания категорий
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('auth.categories.form');
	}

	// Laravel: интернет магазин ч.13: Storage
	/**
	 * Метод сохраняет категорию
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 * 
	 * на вход подаётся параметр класса CategoryRequest для валидации полей формы при заполнении
	 */
	public function store(CategoryRequest $request)
	{
		$params = $request->all();
		unset($params['image']);
		if ($request->has('image')) {
			// указали, что загруженные картинки категорий, должны попадать в папку: storage/categories 
			$params['image'] = $request->file('image')->store('categories');
		}

		Category::create($params);
		return redirect()->route('categories.index');
	}

	/**
	 * Метод открывает(показывает) категорию в админке
	 *
	 * @param \App\Category $category
	 * @return \Illuminate\Http\Response
	 */
	public function show(Category $category)
	{
		return view('auth.categories.show', compact('category'));
	}

	/**
	 * Метод показывает форму для редактирования категорий.
	 *
	 * @param \App\Category $category
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Category $category)
	{
		return view('auth.categories.form', compact('category'));
	}

	// Laravel: интернет магазин ч.13: Storage
	/**
	 * Метод для редактирования категорий
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Category $category
	 * @return \Illuminate\Http\Response
	 * 
	 * на вход подаётся параметр класса CategoryRequest для валидации полей формы при заполнении
	 */
	public function update(CategoryRequest $request, Category $category)
	{
		$params = $request->all();
		unset($params['image']);
		if ($request->has('image')) {
			Storage::delete($category->image);
			$params['image'] = $request->file('image')->store('categories');
		}

		$category->update($params);
		return redirect()->route('categories.index');
	}

	/**
	 * Метод для удаления категорий
	 *
	 * @param \App\Category $category
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Category $category)
	{
		$category->delete();
		return redirect()->route('categories.index');
	}
}
