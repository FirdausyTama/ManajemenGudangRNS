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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi')->unique();
            $table->string('nama_customer');
            $table->text('alamat_customer')->nullable();
            $table->string('no_hp_customer')->nullable();
            $table->date('tanggal_transaksi');
            $table->enum('status_pembayaran', ['lunas', 'belum lunas', 'cicilan'])->default('belum lunas');
            
            // Ongkir fields
            $table->boolean('is_ongkir_aktif')->default(false);
            $table->decimal('berat_total', 10, 2)->nullable();
            $table->decimal('harga_per_kg', 15, 2)->nullable();
            $table->decimal('total_ongkir', 15, 2)->default(0);

            $table->decimal('total_keseluruhan', 15, 2)->default(0);
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
