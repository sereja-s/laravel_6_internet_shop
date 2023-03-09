<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	// Laravel: интернет магазин ч.23: Model Injection, new Class, +ч.30: Collection, Объект Eloquent без сохранения
	// ч.38: Функционал купонов - админка
	protected $fillable = ['user_id', 'currency_id', 'sum', 'coupon_id'];

	// Laravel: интернет магазин ч.35: Eloquent: whereHas
	/** 
	 * Метод возвращает все товарные предложения, которые были заказаны
	 */
	public function skus()
	{
		return $this->belongsToMany(Sku::class)->withPivot(['count', 'price'])->withTimestamps();
	}

	// Laravel: интернет магазин ч.30: Collection, Объект Eloquent без сохранения
	public function currency()
	{
		return $this->belongsTo(Currency::class);
	}

	// Laravel: интернет магазин ч.38: Функционал купонов - админка
	/** 
	 * Метод реализует связь заказа с купоном (один-к-одному)
	 */
	public function coupon()
	{
		return $this->belongsTo(Coupon::class);
	}

	// Laravel: интернет магазин ч.20: Scope, Оптимизация запросов к БД

	public function scopeActive($query)
	{
		return $query->where('status', 1);
	}

	// Laravel: интернет магазин ч.20: Scope, Оптимизация запросов к БД

	public function calculateFullSum()
	{
		$sum = 0;
		// Laravel: интернет магазин ч.22: Кол-во товара, Soft Delete
		// Laravel: интернет магазин ч.35: Eloquent: whereHas
		foreach ($this->skus()->withTrashed()->get() as $sku) {
			$sum += $sku->getPriceForCount();
		}
		return $sum;
	}

	public function getFullSum($withCoupon = true)
	{
		// Laravel: интернет магазин ч.30: Collection, Объект Eloquent без сохранения

		$sum = 0;

		// Laravel: интернет магазин ч.35: Eloquent: whereHas
		foreach ($this->skus as $sku) {
			$sum += $sku->price * $sku->countInOrder;
		}

		if ($withCoupon && $this->hasCoupon()) {
			$sum = $this->coupon->applyCost($sum, $this->currency);
		}

		return $sum;
	}

	public function saveOrder($name, $phone)
	{
		// Laravel: интернет магазин ч.30: Collection, Объект Eloquent без сохранения
		$this->name = $name;
		$this->phone = $phone;
		$this->status = 1;
		$this->sum = $this->getFullSum();

		// +Laravel: интернет магазин ч.35: Eloquent: whereHas

		$skus = $this->skus;
		$this->save();

		foreach ($skus as $skuInOrder) {
			$this->skus()->attach($skuInOrder, [
				'count' => $skuInOrder->countInOrder,
				'price' => $skuInOrder->price,
			]);
		}

		session()->forget('order');
		return true;
	}

	public function hasCoupon()
	{
		return $this->coupon;
	}
}
