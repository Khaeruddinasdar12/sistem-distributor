<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistribusisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distribusis', function (Blueprint $table) {
            $table->id();
            $table->string('no_distribusi')->unique();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('obat_id')->unsigned();
            $table->integer('jumlah_obat');
            $table->bigInteger('pakan_id')->unsigned();
            $table->integer('jumlah_pakan');
            $table->integer('jumlah_ayam');
            $table->enum('status', ['0', '1']); // 0 = belum konfirmasi peternak, 1 = done
            $table->enum('open', ['0', '1']); // 0 = masih berjalan, 1 = tutup
            $table->integer('admin_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');;
            $table->foreign('obat_id')->references('id')->on('obats')->onDelete('cascade');
            $table->foreign('pakan_id')->references('id')->on('pakans')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distribusis');
    }
}
