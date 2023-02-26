<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Laravel: интернет магазин ч.14: Валидация, FormRequest

class CategoryRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true; // установили в true, т.к. хотим чтобы работали правила авторизации (валидации) запроса
	}

	/**
	 * Get the validation rules that apply to the request.
	 * 
	 * Правила валидации полей формы
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'code' => 'required|min:3|max:255|unique:categories,code',
			'name' => 'required|min:3|max:255',
			'description' => 'required|min:5',
		];

		// добавляем правило для поля: code только в том маршруте котоорый нас интересует
		if ($this->route()->named('categories.update')) {
			$rules['code'] .= ',' . $this->route()->parameter('category')->id;
		}

		return $rules;
	}
	/** 
	 * Вернём массив описания ошибок
	 */
	public function messages()
	{
		return [
			'required' => 'Поле :attribute обязательно для ввода',
			'min' => 'Поле :attribute должно иметь минимум :min символов',
			'code.min' => 'Поле код должно содержать не менее :min символов',
		];
	}
}
