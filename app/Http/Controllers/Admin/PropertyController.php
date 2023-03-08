<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyRequest;
use App\Models\Property;

// Laravel: интернет магазин ч.33: Nested Resource Controller

class PropertyController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		// получим все свойства по 10-ть на странице
		$properties = Property::paginate(10);
		//dd($properties);

		// Админка:свойства (admin/properties)

		return view('auth.properties.index', compact('properties'));
	}

	/**
	 * Отображение формы для создания нового свойства
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		// admin/properties/create

		return view('auth.properties.form');
	}

	/**
	 * Метод сохраняет новое свойство
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(PropertyRequest $request)
	{
		// обращаемся к методу модели и добавляем всё из $request(запроса)
		Property::create($request->all());

		// admin/properties

		return redirect()->route('properties.index');
	}

	/**
	 * Метод отображает указанное свойство
	 *
	 * @param  \App\Models\Property  $property
	 * @return \Illuminate\Http\Response
	 */
	public function show(Property $property)
	{
		// admin/properties/{property}

		return view('auth.properties.show', compact('property'));
	}

	/**
	 * Показать форму для редактирования указанного свойства
	 *
	 * @param  \App\Models\Property  $property
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Property $property)
	{
		return view('auth.properties.form', compact('property'));
	}

	/**
	 * редактирование указанного свойства
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Property  $property
	 * @return \Illuminate\Http\Response
	 */
	public function update(PropertyRequest $request, Property $property)
	{
		$property->update($request->all());

		// admin/properties/{property}

		return redirect()->route('properties.index');
	}

	/**
	 * Метод дл удаления указанного св-ва
	 *
	 * @param  \App\Models\Property  $property
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Property $property)
	{
		$property->delete();
		return redirect()->route('properties.index');
	}
}
