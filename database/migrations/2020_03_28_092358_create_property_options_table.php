<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Laravel: интернет магазин ч.32: Товарные предложения. С чего начать?

class CreatePropertyOptionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('property_options', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedInteger('property_id'); // ссылка с каким св-вом продукта мы добавляем связь(белое-цвет и т.д.)
			$table->string('name');
			$table->string('name_en');
			$table->timestamps();

			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('property_options');
	}
}
