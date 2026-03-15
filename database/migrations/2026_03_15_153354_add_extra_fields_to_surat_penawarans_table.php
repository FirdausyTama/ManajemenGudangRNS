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
        Schema::table('surat_penawarans', function (Blueprint $table) {
            $table->string('jabatan_customer')->nullable()->after('nama_customer');
            $table->text('keterangan_pembayaran')->nullable()->after('syarat_ketentuan');
            $table->text('deskripsi_tambahan')->nullable()->after('salam_pembuka');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_penawarans', function (Blueprint $table) {
            $table->dropColumn(['jabatan_customer', 'keterangan_pembayaran', 'deskripsi_tambahan']);
        });
    }
};
