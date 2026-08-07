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
        DB::statement('ALTER TABLE invoices MODIFY penjualan_id bigint unsigned NULL');
        
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('kepada')->nullable()->after('no_invoice');
            $table->text('alamat')->nullable()->after('kepada');
            $table->json('items')->nullable()->after('alamat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('kepada');
            $table->dropColumn('alamat');
            $table->dropColumn('items');
        });
        
        DB::statement('ALTER TABLE invoices MODIFY penjualan_id bigint unsigned NOT NULL');
    }
};
