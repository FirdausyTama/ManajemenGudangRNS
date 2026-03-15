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
        Schema::create('surat_penawaran_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_penawaran_id')->constrained('surat_penawarans')->cascadeOnDelete();
            $table->foreignId('barang_id')->nullable()->constrained('barangs')->nullOnDelete();
            $table->string('nama_barang');
            $table->text('spesifikasi')->nullable();
            $table->decimal('kuantitas', 10, 2);
            $table->string('satuan')->default('Unit');
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('total_harga', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_penawaran_items');
    }
};
