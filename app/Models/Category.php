<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	// ч.27: Eloquent Localization - Мультиязычность данных БД
	use Translatable;

	// поля которые можно заполнять в форме (для редактирования категорий в админке)
	protected $fillable = ['code', 'name', 'description', 'image', 'name_en', 'description_en'];

	// Laravel: интернет магазин ч.5: Eloquent связи
	/** 
	 * Метод определяет отношение один ко многим (в одна категория может иметь много товаров)
	 * Возвращает все товары данной категории
	 * (т.е. категория может получить все данные по товарам в ней из БД)
	 */
	public function products()
	{
		return $this->hasMany(Product::class);
	}
}
