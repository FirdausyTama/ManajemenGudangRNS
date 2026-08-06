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
        Schema::create('rekanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_rekanan')->unique();
            $table->string('jenis_rekanan'); // Customer, Supplier, Vendor
            $table->string('nama_perusahaan');
            $table->string('nama_pic')->nullable();
            $table->string('jabatan_pic')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->string('npwp')->nullable();
            $table->string('nib')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('website')->nullable();
            $table->string('status')->default('Aktif');
            $table->text('catatan')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekanans');
    }
};
