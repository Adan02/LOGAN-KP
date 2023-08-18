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
        Schema::table('moduls', function (Blueprint $table) {
            $table->unsignedBigInteger('bkeluar_id')->after('tanggal_masuk')->nullable();
            $table->foreign('bkeluar_id')->references('id')->on('barang_keluars')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('moduls', function (Blueprint $table) {
            $table->dropForeign(['bkeluar_id']);
            $table->dropColumn('bkeluar_id');
        });
    }
};
