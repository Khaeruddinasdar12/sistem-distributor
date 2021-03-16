<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// pengecer
        DB::table('users')->insert([
	        'name'  => 'pengecer',
	        'email' => 'pengecer@gmail.com',
	        'password'  => bcrypt('12345678'),
	        'role' => 'pengecer',
	        'noktp' => '170170170170',
	        'nohp' => '082123123123',
	        'alamat' => 'Makassar, Tamalanrea, BTP Blok M no. 541',
		]);

        DB::table('users')->insert([
	        'name'  => 'pengecer 2',
	        'email' => 'pengecer2@gmail.com',
	        'password'  => bcrypt('12345678'),
	        'role' => 'pengecer',
	        'noktp' => '170890890111',
	        'nohp' => '082123123123',
	        'alamat' => 'Bone, Tamalanrea, Ujung pandang',
		]);

        // peternak
		DB::table('users')->insert([
	        'name'  => 'peternak',
	        'email' => 'peternak@gmail.com',
	        'password'  => bcrypt('12345678'),
	        'role' => 'peternak',
	        'noktp' => '1772900110922',
	        'nohp' => '082123123123',
	        'alamat' => 'Makassar, Biringkanaya, Perdos',
		]);

		DB::table('users')->insert([
	        'name'  => 'peternak 2',
	        'email' => 'peternak2@gmail.com',
	        'password'  => bcrypt('12345678'),
	        'role' => 'peternak',
	        'noktp' => '18922110011221',
	        'nohp' => '082123123123',
	        'alamat' => 'Bone, Panakkukang, Husjed',
		]);

    }
}
