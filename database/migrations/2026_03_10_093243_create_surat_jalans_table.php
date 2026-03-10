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
        Schema::create('surat_jalans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat_jalan')->unique();
            $table->foreignId('penjualan_id')->constrained('penjualans')->cascadeOnDelete();
            $table->date('tanggal_surat_jalan');
            $table->string('nama_pengirim');
            $table->string('nama_penerima');
            $table->text('alamat_penerima');
            $table->string('telp_penerima');
            $table->string('nama_barang_jasa');
            $table->integer('qty');
            $table->bigInteger('jumlah');
            $table->text('keterangan')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_jalans');
    }
};
