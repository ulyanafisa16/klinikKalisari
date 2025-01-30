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
        Schema::table('pasiens', function (Blueprint $table) {
            $table->unsignedBigInteger('poli_id');
            $table->unsignedBigInteger('jadwal_id');
            $table->time('jam_kunjungan')->nullable();
            $table->enum('tipe_pemeriksaan', ['Klinik', 'Homecare'])->default('Klinik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasiens', function (Blueprint $table) {
            $table->dropColumn(['poli_id', 'jadwal_id', 'jam_kunjungan', 'tipe_pemeriksaan']);
        });
    }
};
