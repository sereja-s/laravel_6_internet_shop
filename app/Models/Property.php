<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Laravel: интернет магазин ч.32: Товарные предложения. С чего начать?

class Property extends Model
{
	use SoftDeletes, Translatable;

	protected $fillable = ['name', 'name_en'];

	/** 
	 * Метод реализует связь свойтва товара с набором свойств (один-ко-многим)
	 */
	public function propertyOptions()
	{
		return $this->hasMany(PropertyOption::class);
	}

	/** 
	 * Метод реализует связь свойств к продуктам (многие-ко-многим)
	 */
	public function products()
	{
		return $this->belongsToMany(Product::class);
	}
}
