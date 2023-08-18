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
        Schema::create('sfps', function (Blueprint $table) {
            $table->id();
            $table->string('jenis', 30);
            $table->string('vendor', 30);
            $table->float('bandwidth');
            $table->integer('lambda');
            $table->integer('jarak');
            $table->string('serial_number', 30);
            $table->dateTime('tanggal_masuk');
            $table->string('hasil', 15)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sfps');
    }
};
