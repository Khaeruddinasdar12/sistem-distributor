<?php

use Illuminate\Database\Seeder;

class PakanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pakans')->insert([
	        'nama'  => 'BR 1 Ac',
	        'stok' => 50,
            'harga' => 50000,
		]);

        DB::table('pakans')->insert([
            'nama'  => 'BR 1 Parama',
            'stok' => 50,
            'harga' => 55000,
        ]);

        DB::table('pakans')->insert([
            'nama'  => 'Broiler 0 Hg',
            'stok' => 50,
            'harga' => 45000,
        ]);
    }
}
