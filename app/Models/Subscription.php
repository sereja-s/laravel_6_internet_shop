<?php

namespace App\Models;

use App\Mail\SendSubscriptionMessage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

// Laravel: интернет магазин ч.25: Observer (подписка на отсутствующий товар)

// +Laravel: интернет магазин ч.35: Eloquent: whereHas
class Subscription extends Model
{
	protected $fillable = ['email', 'sku_id'];

	public function scopeActiveBySkuId($query, $skuId)
	{
		return $query->where('status', 0)->where('sku_id', $skuId);
	}

	/** 
	 * Метод реализует связь один-к-одному с моделью Sku (+Laravel: интернет магазин ч.35: Eloquent: whereHas)
	 */
	public function sku()
	{
		return $this->belongsTo(Sku::class);
	}

	// +Laravel: интернет магазин ч.35: Eloquent: whereHas
	public static function sendEmailsBySubscription(Sku $sku)
	{
		// получим все подписки
		$subscriptions = self::activeBySkuId($sku->id)->get();

		// пробежимся по каждой подписке в цикле и отправим её
		foreach ($subscriptions as $subscription) {
			Mail::to($subscription->email)->send(new SendSubscriptionMessage($sku));
			$subscription->status = 1;
			$subscription->save();
		}
	}
}
