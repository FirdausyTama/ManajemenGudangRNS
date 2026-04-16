<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penjualan;
use App\Models\PenjualanItem;
use App\Models\Barang;
use App\Models\Kwitansi;
use App\Models\User;
use Carbon\Carbon;

class CicilanTestSeeder extends Seeder
{
    public function run(): void
    {
        try {
            $user = User::first();
            $barang = Barang::first();

            if (!$barang) {
                $this->command->error('Harap isi data barang terlebih dahulu sebelum menjalankan seeder ini.');
                return;
            }

        // 1. Cicilan yang akan jatuh tempo dalam 3 hari (Tipe: Belum pernah bayar cicilan)
        // Tanggal transaksi = 1 bulan yang lalu + 3 hari
        $date1 = Carbon::now()->subMonth()->addDays(3);
        $p1 = Penjualan::create([
            'no_transaksi' => 'TRX-TEST-001',
            'nama_customer' => 'Customer Test 1 (Jatuh Tempo H-3)',
            'alamat_customer' => 'Alamat Test 1',
            'no_hp_customer' => '08123456789',
            'tanggal_transaksi' => $date1,
            'status_pembayaran' => 'cicilan',
            'tenor_bulan' => 12,
            'total_keseluruhan' => 12000000,
            'user_id' => $user->id ?? null,
        ]);

        PenjualanItem::create([
            'penjualan_id' => $p1->id,
            'barang_id' => $barang->id,
            'kuantitas' => 1,
            'harga_satuan' => 12000000,
            'total_harga' => 12000000,
        ]);

        // 2. Cicilan yang akan jatuh tempo dalam 6 hari (Tipe: Sudah bayar cicilan ke-1)
        // Tanggal transaksi = 2 bulan yang lalu + 6 hari
        // Maka cicilan ke-1 jatuh tempo 1 bulan yang lalu (sudah bayar)
        // Cicilan ke-2 jatuh tempo 6 hari lagi
        $date2 = Carbon::now()->subMonths(2)->addDays(6);
        $p2 = Penjualan::create([
            'no_transaksi' => 'TRX-TEST-002',
            'nama_customer' => 'Customer Test 2 (Jatuh Tempo H-6)',
            'alamat_customer' => 'Alamat Test 2',
            'no_hp_customer' => '08987654321',
            'tanggal_transaksi' => $date2,
            'status_pembayaran' => 'cicilan',
            'tenor_bulan' => 6,
            'total_keseluruhan' => 6000000,
            'user_id' => $user->id ?? null,
        ]);

        PenjualanItem::create([
            'penjualan_id' => $p2->id,
            'barang_id' => $barang->id,
            'kuantitas' => 1,
            'harga_satuan' => 6000000,
            'total_harga' => 6000000,
        ]);

        // Tambah kwitansi cicilan ke-1 agar cicilan_paid_count = 1
        Kwitansi::create([
            'penjualan_id' => $p2->id,
            'nomor_kwitansi' => 'KWT/TEST/001',
            'tanggal_kwitansi' => $date2->copy()->addMonth(),
            'total_pembayaran' => 1000000,
            'total_bilangan' => 'Satu Juta Rupiah',
            'nama_penerima' => 'Customer Test 2',
            'alamat_penerima' => 'Alamat Test 2',
            'penandatangan' => 'Admin RNS',
            'keterangan' => 'Pembayaran Cicilan ke-1',
            'user_id' => $user->id ?? null,
        ]);

        $this->command->info('Seed data cicilan berhasil dibuat untuk pengetesan dashboard.');
        } catch (\Exception $e) {
            $this->command->error('Gagal membuat seeder: ' . $e->getMessage());
        }
    }
}
