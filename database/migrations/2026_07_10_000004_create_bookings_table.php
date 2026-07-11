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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('kendaraan_id')->constrained('kendaraans')->restrictOnDelete();
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->nullOnDelete();
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            $table->string('lokasi_jemput');
            $table->string('lokasi_tujuan')->nullable();
            $table->unsignedInteger('durasi_hari');
            $table->decimal('total_kendaraan', 12, 2);
            $table->decimal('total_driver', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2);
            $table->enum('status', ['pending', 'confirmed', 'ongoing', 'completed', 'cancelled'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('kendaraan_id');
            $table->index('driver_id');
            $table->index('status');
            $table->index('tanggal_mulai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
