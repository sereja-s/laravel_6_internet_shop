<?php

namespace App\Mail;

use App\Models\Sku;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

// Laravel: интернет магазин ч.25: Observer (подписка на отсутствующий товар)

class SendSubscriptionMessage extends Mailable
{
	use Queueable, SerializesModels;

	protected $sku;

	public function __construct(Sku $sku)
	{
		$this->sku = $sku;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->view('mail.subscription', ['sku' => $this->sku]);
	}
}
