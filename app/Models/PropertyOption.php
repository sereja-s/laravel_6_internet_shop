<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Laravel: интернет магазин ч.32: Товарные предложения. С чего начать?

class PropertyOption extends Model
{
	use SoftDeletes, Translatable;

	protected $fillable = ['property_id', 'name', 'name_en'];

	/** 
	 * Метод реализует связь набора свойств со свойством (один-к-одному)
	 */
	public function property()
	{
		return $this->belongsTo(Property::class);
	}

	/** 
	 * Метод реализует связь набора свойств с товарными предложениями (многие-ко-многим)
	 */
	public function skus()
	{
		return $this->belongsToMany(Sku::class);
	}
}
