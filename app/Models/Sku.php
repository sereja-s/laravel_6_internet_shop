<?php

namespace App\Models;

use App\Services\CurrencyConversion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Laravel: интернет магазин ч.32: Товарные предложения. С чего начать?
// Laravel: интернет магазин ч.34: Plural & Singular

class Sku extends Model
{
	use SoftDeletes;

	protected $fillable = ['product_id', 'count', 'price'];
	protected $visible = ['id', 'count', 'price', 'product_name'];

	/** 
	 * Метод реализует связь товарного предлложения с продуктом (один-к-одному)
	 */
	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function scopeAvailable($query)
	{
		return $query->where('count', '>', 0);
	}

	// Laravel: интернет магазин ч.32: Товарные предложения. С чего начать?, ч.34
	public function propertyOptions()
	{ 	// вторым параметром передаём название соответствующей таблицы связи в БД
		return $this->belongsToMany(PropertyOption::class, 'sku_property_option')->withTimestamps();
	}

	// Laravel: интернет магазин ч.35: Eloquent: whereHas
	public function isAvailable()
	{
		// проверяем что продукт не удалён и его кол-во больше нуля
		return !$this->product->trashed() && $this->count > 0;
	}

	// Laravel: интернет магазин ч.35: Eloquent: whereHas
	public function getPriceForCount()
	{
		if (!is_null($this->pivot)) {
			return $this->pivot->count * $this->price;
		}
		return $this->price;
	}

	public function getPriceAttribute($value)
	{
		return round(CurrencyConversion::convert($value), 2);
	}

	public function getProductNameAttribute()
	{
		return $this->product->name;
	}
}
