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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete()->unique();
            $table->enum('metode', ['transfer_manual', 'qris', 'va', 'cash'])->default('transfer_manual');
            $table->decimal('jumlah_bayar', 12, 2);
            $table->enum('status', ['belum_bayar', 'menunggu_verifikasi', 'lunas', 'refund', 'ditolak'])->default('belum_bayar');
            $table->string('bukti_bayar')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->dateTime('tanggal_bayar')->nullable();
            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
