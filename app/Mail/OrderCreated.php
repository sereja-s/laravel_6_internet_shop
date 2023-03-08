<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

// Laravel: интернет магазин ч.24: Отправка Email

class OrderCreated extends Mailable
{
	use Queueable, SerializesModels;

	protected $name;
	protected $order;

	/**
	 * OrderCreated constructor.
	 * @param $name
	 * @param $order
	 */
	public function __construct($name, Order $order)
	{
		$this->name = $name;
		$this->order = $order;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		// Laravel: интернет магазин ч.30: Collection, Объект Eloquent без сохранения

		$fullSum = $this->order->getFullSum();
		return $this->view('mail.order_created', [
			'name' => $this->name,
			'fullSum' => $fullSum,
			'order' => $this->order
		]);
	}
}
