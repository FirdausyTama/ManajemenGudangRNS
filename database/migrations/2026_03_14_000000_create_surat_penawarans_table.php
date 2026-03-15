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
        Schema::create('surat_penawarans', function (Blueprint $table) {
            $table->id();
            $table->string('no_sph')->unique();
            $table->string('nama_customer');
            $table->text('alamat_customer')->nullable();
            $table->string('no_hp_customer')->nullable();
            $table->date('tanggal_sph');
            $table->string('perihal');
            $table->text('salam_pembuka')->nullable();
            $table->text('salam_penutup')->nullable();
            $table->text('syarat_ketentuan')->nullable();
            $table->string('penandatangan');
            $table->decimal('total_harga', 15, 2)->default(0);
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_penawarans');
    }
};
