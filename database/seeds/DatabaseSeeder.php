<?php

use Illuminate\Database\Seeder;

// Laravel: интернет магазин ч.16: Seeder, ч.28: Мультивалюта

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call(UsersTableSeeder::class);
		$this->call(CurrencySeeder::class);
		$this->call(ContentSeeder::class);
	}
}
