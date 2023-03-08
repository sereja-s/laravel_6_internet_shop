<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Laravel: интернет магазин ч.28: Мультивалюта

class Currency extends Model
{
	protected $fillable = ['rate'];

	public function scopeByCode($query, $code)
	{
		return $query->where('code', $code);
	}

	/*** 
	 * Метод показывает, что валюта является базовой
	 */
	public function isMain()
	{
		return $this->is_main === 1;
	}
}
