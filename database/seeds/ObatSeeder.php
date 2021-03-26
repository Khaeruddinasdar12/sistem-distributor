<?php

use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('obats')->insert([
	        'nama'  => 'Ammotrol 100gr',
	        'stok' => 30,
	        'harga' =>  17063,
		]);

		DB::table('obats')->insert([
	        'nama'  => 'Amoxitin 100gr',
	        'stok' => 30,
	        'harga' =>  44587,
		]);

		DB::table('obats')->insert([
	        'nama'  => 'Ampicol',
	        'stok' => 30,
	        'harga' =>  79560,
		]);

		DB::table('obats')->insert([
	        'nama'  => 'AntiSep',
	        'stok' => 30,
	        'harga' =>  203093,
		]);

		DB::table('obats')->insert([
	        'nama'  => 'AntiSep 120 ml',
	        'stok' => 30,
	        'harga' =>  27018,
		]);

		DB::table('obats')->insert([
	        'nama'  => 'Asortin 3L',
	        'stok' => 30,
	        'harga' =>  106177,
		]);

		DB::table('obats')->insert([
	        'nama'  => 'Benzalti 1L',
	        'stok' => 30,
	        'harga' =>  87120,
		]);

		DB::table('obats')->insert([
	        'nama'  => 'Doctril 250gr',
	        'stok' => 30,
	        'harga' =>  54064,
		]);

		DB::table('obats')->insert([
	        'nama'  => 'Eridoxty 100gr',
	        'stok' => 30,
	        'harga' =>  63180,
		]);

		DB::table('obats')->insert([
	        'nama'  => 'Fithera 250ml',
	        'stok' => 30,
	        'harga' =>  38123,
		]);
    }
}
