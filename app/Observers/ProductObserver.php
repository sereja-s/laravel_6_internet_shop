<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Subscription;

// Laravel: интернет магазин ч.25: Observer (подписка на отсутствующий товар)

class ProductObserver
{
	public function updating(Product $product)
	{
		$oldCount = $product->getOriginal('count');

		// если кол-во товара было ноль и кол-во товара увеличилось
		if ($oldCount == 0 && $product->count > 0) {
			Subscription::sendEmailsBySubscription($product);
		}
	}
}
