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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_driver');
            $table->string('no_telp', 20);
            $table->text('alamat');
            $table->enum('sim', ['A', 'B1', 'B2']);
            $table->decimal('tarif_per_hari', 12, 2);
            $table->enum('status', ['aktif', 'tidak_aktif', 'sedang_bertugas'])->default('aktif');
            $table->string('foto');
            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
