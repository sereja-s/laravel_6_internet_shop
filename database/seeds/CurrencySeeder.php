<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// Laravel: интернет магазин ч.28: Мультивалюта

class CurrencySeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('currencies')->truncate();

		DB::table('currencies')->insert([
			[
				'code' => 'RUB',
				'symbol' => '₽',
				'is_main' => 1,
				'rate' => 1,
				'updated_at' => Carbon::now(),
				'created_at' => Carbon::now(),
			],
			[
				'code' => 'USD',
				'symbol' => '$',
				'is_main' => 0,
				'rate' => 0, // курс относительно рубля
				'updated_at' => Carbon::now(),
				'created_at' => Carbon::now(),
			],
			[
				'code' => 'EUR',
				'symbol' => '€',
				'is_main' => 0,
				'rate' => 0,
				'updated_at' => Carbon::now(),
				'created_at' => Carbon::now(),
			],
		]);
	}
}
