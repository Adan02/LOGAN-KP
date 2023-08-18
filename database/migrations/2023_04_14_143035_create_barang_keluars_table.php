<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang_keluars', function (Blueprint $table) {
            $table->id();
            $table->string('kebutuhan', 255);
            $table->string('instansi_pemberi', 255);
            $table->string('nama_pemberi', 100);
            $table->string('nik_pemberi', 30);
            $table->string('instansi_penerima', 255);
            $table->string('nama_penerima', 100);
            $table->string('nik_penerima', 30);
            $table->dateTime('tanggal_keluar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluars');
    }
};
