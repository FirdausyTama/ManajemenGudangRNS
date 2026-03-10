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
        Schema::create('kwitansis', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kwitansi')->unique();
            $table->foreignId('penjualan_id')->constrained('penjualans')->cascadeOnDelete();
            $table->date('tanggal_kwitansi');
            $table->string('nama_penerima');
            $table->string('alamat_penerima');
            $table->string('total_bilangan');
            $table->text('keterangan');
            $table->bigInteger('total_pembayaran');
            $table->string('penandatangan');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kwitansis');
    }
};
