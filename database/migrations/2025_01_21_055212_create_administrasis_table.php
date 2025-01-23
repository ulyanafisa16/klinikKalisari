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
        Schema::create('administrasis', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('kode_administrasi');
            $table->integer('pasien_id');
            $table->integer('dokter_id');
            $table->string('poli');
            $table->integer('biaya');
            $table->text('keluhan')->nullable();
            $table->text('diagnosis')->nullable();
            $table->string('status', 10)->nullable()->default('baru');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrasis');
    }
};
