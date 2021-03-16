<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanHariansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_harians', function (Blueprint $table) {
            $table->id();
            $table->integer('distribusi_id');
            $table->integer('jumlah_ayam');
            $table->integer('umur_ayam');
            $table->integer('total_kematian');
            $table->string('bw');
            $table->string('fcr');
            $table->integer('total_pakan_terpakai');
            $table->integer('stok_pakan');
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
        Schema::dropIfExists('laporan_harians');
    }
}
