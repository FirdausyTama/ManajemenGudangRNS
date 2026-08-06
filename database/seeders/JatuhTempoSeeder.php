<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Barang;
use App\Models\Penjualan;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class JatuhTempoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::create([
            'name' => 'Admin Demo',
            'email' => 'demo@example.com',
            'password' => bcrypt('password'),
        ]);

        // Hapus data lama jika ada
        Penjualan::where('no_transaksi', 'TRX-JATUH-TEMPO-1')->delete();

        // Buat transaksi yang akan jatuh tempo dalam 3 hari ke depan
        $now = Carbon::now();
        // Beli sebulan yang lalu ditambah 3 hari -> jatuh tempo bulan ke-1 adalah 3 hari dari sekarang
        $tanggalTransaksi = $now->copy()->subMonth()->addDays(3);

        Penjualan::create([
            'no_transaksi' => 'TRX-JATUH-TEMPO-1',
            'nama_customer' => 'Bapak Budi (Jatuh Tempo)',
            'alamat_customer' => 'Jl. Contoh Jatuh Tempo No. 1',
            'tanggal_transaksi' => $tanggalTransaksi->toDateString(),
            'status_pembayaran' => 'cicilan',
            'tenor_bulan' => 6,
            'total_keseluruhan' => 12000000,
            'user_id' => $user->id
        ]);

        echo "Seeder berhasil dijalankan! Transaksi jatuh tempo (3 hari dari sekarang) telah ditambahkan.\n";
    }
}
