<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Laravel: интернет магазин ч.18: Pagination, QueryBuilder, Фильтры

class ProductsFilterRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'price_from' => 'nullable|numeric|min:0',
			'price_to' => 'nullable|numeric|min:0',
		];
	}
}
