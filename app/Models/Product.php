<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use App\Services\CurrencyConversion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
	// Laravel: интернет магазин ч.22: Кол-во товара, Soft Delete, ч.27: Eloquent Localization - Мультиязычность данных БД
	// добавили трейт
	use SoftDeletes, Translatable;

	// Laravel: интернет магазин +ч.17: Checkbox, Mutator, ч.22: Кол-во товара, Soft Delete, ч.27: Eloquent Localization - Мультиязычность данных БД
	// добавляем поля что бы могли их редактировать
	protected $fillable = [
		'name', 'code', 'price', 'category_id', 'description', 'image', 'hit', 'new', 'recommend', 'count', 'name_en',
		'description_en'
	];

	// Laravel: интернет магазин ч.5: Eloquent связи
	/** 
	 * Метод  определяет обратное отношение "один к одному"(продукт(товар) принадлежит к одной категории) 
	 * Возвращает одну категорию, к которой принадлежит конкретный товар
	 * (т.е. товар связывается со своей категорией и может получать все данные по ней из БД)
	 */
	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	// Laravel: интернет магазин ч.32: Товарные предложения. С чего начать?
	/** 
	 * Метод реализует связь продукта с товарными предложениями (один-ко-многим)
	 */
	public function skus()
	{
		return $this->hasMany(Sku::class);
	}

	// Laravel: интернет магазин ч.32: Товарные предложения. С чего начать?, ч.34: Plural & Singular
	/** 
	 * Метод реализует связь продуктов со свойствами (многие-ко-многим)
	 */
	public function properties()
	{
		return $this->belongsToMany(Property::class, 'property_product')->withTimestamps();
	}

	// Laravel: интернет магазин ч.22: Кол-во товара, Soft Delete
	public function scopeByCode($query, $code)
	{
		return $query->where('code', $code);
	}

	// Laravel: интернет магазин ч.20: Scope(позволяет расширять запросы к БД), Оптимизация запросов к БД

	public function scopeHit($query)
	{
		return $query->where('hit', 1);
	}

	public function scopeNew($query)
	{
		return $query->where('new', 1);
	}

	public function scopeRecommend($query)
	{
		return $query->where('recommend', 1);
	}

	// Laravel: интернет магазин ч.17: Checkbox, Mutator(функция, которая будет вызываться перед тем как будет 
	// происходить сохранение соответствующего атрибута)

	public function setNewAttribute($value)
	{
		$this->attributes['new'] = $value === 'on' ? 1 : 0;
	}

	public function setHitAttribute($value)
	{
		$this->attributes['hit'] = $value === 'on' ? 1 : 0;
	}

	public function setRecommendAttribute($value)
	{
		$this->attributes['recommend'] = $value === 'on' ? 1 : 0;
	}

	// Laravel: интернет магазин ч.17: Checkbox, Mutator

	public function isHit()
	{
		return $this->hit === 1;
	}

	public function isNew()
	{
		return $this->new === 1;
	}

	public function isRecommend()
	{
		return $this->recommend === 1;
	}
}
