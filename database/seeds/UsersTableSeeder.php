<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// Laravel: интернет магазин ч.16: Seeder

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users')->insert([
			'name' => 'Администратор',
			'email' => 'admin@example.com',
			'password' => bcrypt('admin'),
			'is_admin' => 1,
		]);
	}
}
