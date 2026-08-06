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
        Schema::create('dokumen_rekanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rekanan_id')->constrained('rekanans')->cascadeOnDelete();
            $table->string('nama_dokumen');
            $table->string('kategori_dokumen');
            $table->string('file_path');
            $table->string('nama_file');
            $table->string('ukuran_file')->nullable();
            $table->string('tipe_file')->nullable();
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_rekanans');
    }
};
