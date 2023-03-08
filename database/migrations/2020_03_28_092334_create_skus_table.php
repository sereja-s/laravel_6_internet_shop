<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Laravel: интернет магазин ч.32: Товарные предложения. С чего начать?

class CreateSkusTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('skus', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedInteger('product_id'); // ссылка к какому продукту мы добавляем связь
			$table->unsignedInteger('count')->default(0); // кол-во данного товара (товарного предложения) по умолчанию ноль
			$table->double('price')->default(0);
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
		Schema::dropIfExists('skus');
	}
}
