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
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kendaraan');
            $table->string('plat_nomor')->unique();
            $table->enum('jenis', ['sedan', 'suv', 'mpv', 'minibus', 'truk']);
            $table->string('warna', 50);
            $table->year('tahun');
            $table->unsignedInteger('kapasitas');
            $table->decimal('harga_sewa_per_hari', 12, 2);
            $table->string('gambar');
            $table->text('deskripsi');
            $table->enum('status', ['tersedia', 'disewa', 'service'])->default('tersedia');
            $table->timestamps();

            $table->index('jenis');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};
