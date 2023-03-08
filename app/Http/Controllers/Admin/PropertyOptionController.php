<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyOptionRequest;
use App\Models\Property;
use App\Models\PropertyOption;

// Laravel: интернет магазин ч.33: Nested Resource Controller

class PropertyOptionController extends Controller
{
	/**
	 * Отображение списка набора свойств
	 *
	 * @param  Property  $property объект модели
	 * @return \Illuminate\Http\Response
	 */
	public function index(Property $property)
	{
		//$propertyOptions = PropertyOption::paginate(10);
		$propertyOptions = PropertyOption::where('property_id', $property->id)->paginate(10);

		//dd($property);

		// admin/properties/{property}/property-options

		return view('auth.property_options.index', compact('propertyOptions', 'property'));
	}

	/**
	 * Показать форму для создания нового варианта свойства
	 *
	 * @param  Property  $property
	 * @return \Illuminate\Http\Response
	 */
	public function create(Property $property)
	{
		// admin/properties/{property}/property-options/create

		return view('auth.property_options.form', compact('property'));
	}

	/**
	 * Метод сохраняет данные из заполненной формы добавления варианта свойств
	 *
	 * @param  PropertyOptionRequest  $request
	 * @param  Property  $property
	 * @return \Illuminate\Http\Response
	 */
	public function store(PropertyOptionRequest $request, Property $property)
	{
		$params = $request->all();
		$params['property_id'] = $request->property->id;

		//dd($params);

		PropertyOption::create($params);

		// admin/properties/{property}/property-options

		return redirect()->route('property-options.index', $property);
	}

	/**
	 * Отобразить указанный вариант свойства
	 *
	 * @param  Property  $property
	 * @param  \App\Models\PropertyOption  $propertyOption
	 * @return void
	 */
	public function show(Property $property, PropertyOption $propertyOption)
	{


		//admin/properties/{property}/property-options/{property_option}

		return view('auth.property_options.show', compact('propertyOption'));
	}

	/**
	 * Показать форму для редактирования указанного варианта свойства
	 *
	 * @param  \App\Models\PropertyOption  $propertyOption
	 * @param  Property  $property
	 * @return void
	 */
	public function edit(Property $property, PropertyOption $propertyOption)
	{
		// admin/properties/{property}/property-options/{property_option}/edit

		return view('auth.property_options.form', compact('property', 'propertyOption'));
	}

	/**
	 * Редактировать указанный вариант свойства
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  Property  $property
	 * @param  \App\Models\PropertyOption  $propertyOption
	 * @return \Illuminate\Http\Response
	 */
	public function update(PropertyOptionRequest $request, Property $property, PropertyOption $propertyOption)
	{
		$params = $request->all();

		$propertyOption->update($params);

		// admin/properties/{property}/property-options/{property_option}

		return redirect()->route('property-options.index', $property);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  Property  $property
	 * @param  \App\Models\PropertyOption  $propertyOption
	 * @return \Illuminate\Http\Response
	 * @throws \Exception
	 */
	public function destroy(Property $property, PropertyOption $propertyOption)
	{
		$propertyOption->delete();

		//dd($propertyOption);

		// admin/properties/{property}/property-options/{property_option}

		return redirect()->route('property-options.index', $property);
	}
}
