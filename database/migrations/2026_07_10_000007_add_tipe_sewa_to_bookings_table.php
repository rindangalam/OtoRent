<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('tipe_sewa')->default('lepas_kunci')->after('kendaraan_id');
            $table->string('metode_antar')->nullable()->after('tipe_sewa');
            $table->decimal('ongkos_antar', 12, 2)->default(0)->after('metode_antar');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['tipe_sewa', 'metode_antar', 'ongkos_antar']);
        });
    }
};
