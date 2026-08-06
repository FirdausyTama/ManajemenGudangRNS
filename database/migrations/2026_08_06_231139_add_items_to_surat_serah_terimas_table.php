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
        Schema::table('surat_serah_terimas', function (Blueprint $table) {
            $table->json('items')->nullable()->after('keterangan');
            $table->string('nama_barang')->nullable()->change();
            $table->string('qty')->nullable()->change();
            $table->string('jumlah')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_serah_terimas', function (Blueprint $table) {
            //
        });
    }
};
