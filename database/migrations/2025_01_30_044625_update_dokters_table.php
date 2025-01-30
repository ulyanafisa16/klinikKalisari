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
        Schema::table('dokters', function (Blueprint $table) {
            $table->unsignedBigInteger('poli_id')->after('id'); // Menambahkan kolom poli_id
            $table->dropColumn('spesialis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokters', function (Blueprint $table) {
            $table->dropColumn('poli_id'); // Menghapus kolom poli_id jika rollback
            $table->string('spesialis')->nullable();
        });
    }
};
