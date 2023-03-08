<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Laravel: интернет магазин ч.32: Товарные предложения. С чего начать?

// Таблица отвечает за свойства товаров доступные для конкретного товара (в карточке товара мы должны будем указывать 
// какие св-ва этот товар поддерживает, что бы без всего набора этих свойств не мог быть добавлен тоар)
class CreatePropertyProduct extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('property_product', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedInteger('product_id');
			$table->unsignedInteger('property_id');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('property_product');
	}
}
