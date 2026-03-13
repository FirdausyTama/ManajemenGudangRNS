<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\Kwitansi;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DemoReminderSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure User 1 exists
        $user = User::first() ?? User::create([
            'name' => 'Admin Demo',
            'email' => 'demo@example.com',
            'password' => bcrypt('password'),
        ]);

        // 2. Cleanup existing demo transactions (to avoid unique constraint errors)
        $demoTrxs = ['TRX-DEMO-001', 'TRX-DEMO-002', 'TRX-DEMO-003', 'TRX-DEMO-004', 'TRX-DEMO-005'];
        Penjualan::whereIn('no_transaksi', $demoTrxs)->delete();

        // 3. Ensure a product exists
        $barang = Barang::first() ?? Barang::create([
            'sku' => 'BRG-DEMO-001',
            'name' => 'Produk Demo Seeder',
            'selling_price' => 1000000,
            'stock' => 100,
            'user_id' => $user->id
        ]);

        // Clear existing demo-like data to avoid clutter if needed, but here we just append
        
        // --- TRANSAKSI 1: Jatuh tempo 2 hari lagi (15 Maret) ---
        // Trx Tgl 15 Jan 2026, Tenor 6 bln, sudah bayar 1x (Cicilan 1: 15 Feb). Next: Cicilan 2 (15 Mar)
        $p1 = Penjualan::create([
            'no_transaksi' => 'TRX-DEMO-001',
            'nama_customer' => 'Siti Aminah (Demo)',
            'tanggal_transaksi' => '2026-01-15',
            'status_pembayaran' => 'cicilan',
            'tenor_bulan' => 6,
            'total_keseluruhan' => 6000000,
            'user_id' => $user->id
        ]);
        // Cicilan 1 sudah dibayar
        Kwitansi::create([
            'nomor_kwitansi' => 'KWT-DEMO-001',
            'penjualan_id' => $p1->id,
            'tanggal_kwitansi' => '2026-02-15',
            'nama_penerima' => 'Siti Aminah',
            'alamat_penerima' => 'Jl. Kartini No. 10 (Demo)',
            'total_bilangan' => 'Satu Juta Rupiah',
            'total_pembayaran' => 1000000,
            'keterangan' => 'Pembayaran Cicilan ke-1',
            'penandatangan' => $user->name,
            'user_id' => $user->id
        ]);

        // --- TRANSAKSI 2: Jatuh tempo 4 hari lagi (17 Maret) ---
        // Trx Tgl 17 Feb 2026, Tenor 3 bln, belum bayar cicilan sama sekali. Next: Cicilan 1 (17 Mar)
        $p2 = Penjualan::create([
            'no_transaksi' => 'TRX-DEMO-002',
            'nama_customer' => 'Toko Berkah (Demo)',
            'alamat_customer' => 'Pasar Baru Blok A (Demo)',
            'tanggal_transaksi' => '2026-02-17',
            'status_pembayaran' => 'cicilan',
            'tenor_bulan' => 3,
            'total_keseluruhan' => 3000000,
            'user_id' => $user->id
        ]);

        // --- TRANSAKSI 3: Jatuh tempo tepat 7 hari lagi (20 Maret) ---
        // Trx Tgl 20 Des 2025, Tenor 12 bln, sudah bayar 2x (Jan, Feb). Next: Cicilan 3 (20 Mar)
        $p3 = Penjualan::create([
            'no_transaksi' => 'TRX-DEMO-003',
            'nama_customer' => 'Haji Malik (Demo)',
            'alamat_customer' => 'Kawasan Industri (Demo)',
            'tanggal_transaksi' => '2025-12-20',
            'status_pembayaran' => 'cicilan',
            'tenor_bulan' => 12,
            'total_keseluruhan' => 12000000,
            'user_id' => $user->id
        ]);
        // Cicilan 1 & 2
        for($i=1; $i<=2; $i++) {
            Kwitansi::create([
                'nomor_kwitansi' => 'KWT-DEMO-00' . ($i+1),
                'penjualan_id' => $p3->id,
                'tanggal_kwitansi' => "2026-0{$i}-20",
                'nama_penerima' => 'Haji Malik',
                'alamat_penerima' => 'Kawasan Industri (Demo)',
                'total_bilangan' => 'Satu Juta Rupiah',
                'total_pembayaran' => 1000000,
                'keterangan' => "Pembayaran Cicilan ke-{$i}",
                'penandatangan' => $user->name,
                'user_id' => $user->id
            ]);
        }

        // --- TRANSAKSI 4: Jatuh tempo hari ini (13 Maret) ---
        // Trx Tgl 13 Feb 2026, Tenor 10 bln, belum bayar. Next: Cicilan 1 (13 Mar)
        Penjualan::create([
            'no_transaksi' => 'TRX-DEMO-004',
            'nama_customer' => 'Budi Santoso (Demo)',
            'alamat_customer' => 'Perumahan Griya (Demo)',
            'tanggal_transaksi' => '2026-02-13',
            'status_pembayaran' => 'cicilan',
            'tenor_bulan' => 10,
            'total_keseluruhan' => 5000000,
            'user_id' => $user->id
        ]);

        // --- TRANSAKSI 5: Lewat jatuh tempo (Sudah bayar bulan ini) ---
        // Trx Tgl 10 Feb 2026, Tenor 10 bln. Cicilan 1 (10 Mar) sudah bayar. Next: 10 Apr (OUTSIDE WINDOW)
        $p5 = Penjualan::create([
            'no_transaksi' => 'TRX-DEMO-005',
            'nama_customer' => 'Andi (Demo Lunas Bulan Ini)',
            'alamat_customer' => 'Jl. Sudirman (Demo)',
            'tanggal_transaksi' => '2026-02-10',
            'status_pembayaran' => 'cicilan',
            'tenor_bulan' => 10,
            'total_keseluruhan' => 5000000,
            'user_id' => $user->id
        ]);
        Kwitansi::create([
            'nomor_kwitansi' => 'KWT-DEMO-005',
            'penjualan_id' => $p5->id,
            'tanggal_kwitansi' => '2026-03-10',
            'nama_penerima' => 'Andi',
            'alamat_penerima' => 'Jl. Sudirman (Demo)',
            'total_bilangan' => 'Lima Ratus Ribu Rupiah',
            'total_pembayaran' => 500000,
            'keterangan' => 'Pembayaran Cicilan ke-1',
            'penandatangan' => $user->name,
            'user_id' => $user->id
        ]);
    }
}
