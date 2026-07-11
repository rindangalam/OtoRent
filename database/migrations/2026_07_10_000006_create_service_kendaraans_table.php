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
        Schema::create('service_kendaraans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kendaraan_id')->constrained('kendaraans')->cascadeOnDelete();
            $table->enum('jenis_service', ['rutin', 'perbaikan', 'ganti_suku_cadang']);
            $table->text('deskripsi');
            $table->decimal('biaya', 12, 2);
            $table->date('tanggal_service');
            $table->date('estimasi_selesai')->nullable();
            $table->enum('status', ['dijadwalkan', 'sedang_dikerjakan', 'selesai'])->default('dijadwalkan');
            $table->timestamps();

            $table->index('kendaraan_id');
            $table->index('status');
            $table->index('tanggal_service');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_kendaraans');
    }
};
