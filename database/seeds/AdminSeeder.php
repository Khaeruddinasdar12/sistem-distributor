<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
	        'name'  => 'Khaeruddin Asdar',
	        'email' => 'khaeruddinasdar12@gmail.com',
	        'password'  => bcrypt('12345678'),
		]);
    }
}
