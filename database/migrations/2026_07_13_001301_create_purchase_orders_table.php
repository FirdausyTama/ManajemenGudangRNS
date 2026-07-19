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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('no_po')->unique();
            $table->string('supplier_name');
            $table->text('supplier_address')->nullable();
            $table->date('tanggal_po');
            $table->string('pembayaran')->nullable();
            $table->text('catatan')->nullable();
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
        Schema::dropIfExists('purchase_orders');
    }
};
