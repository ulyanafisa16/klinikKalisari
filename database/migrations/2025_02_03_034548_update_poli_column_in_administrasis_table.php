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
        Schema::table('administrasis', function (Blueprint $table) {
            $table->dropColumn('poli'); // Hapus kolom lama
            $table->integer('poli_id'); // Tambahkan poli_id sebagai integer
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('administrasis', function (Blueprint $table) {
            $table->dropColumn('poli_id'); // Hapus poli_id
            $table->string('poli')->nullable(); 
        });
    }
};
