<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Penjualan - {{ $penjualan->no_transaksi }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        rns: {
                            blue: '#1e3a8a',
                            light: '#3b82f6',
                        }
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F3F4F6; }
    </style>
</head>
<body class="text-gray-800 flex h-screen overflow-x-hidden">

    @include('layouts.navbar')

    <!-- Main Content -->
    <main id="main-content" class="flex-1 md:ml-64 pt-16 flex flex-col h-screen overflow-x-hidden relative transition-all duration-300">
        <div class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8 relative w-full">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto relative z-10">
                
                <!-- Page Header -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <a href="{{ route('penjualan.index') }}" class="p-1.5 text-gray-500 hover:text-gray-800 hover:bg-gray-200 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            </a>
                            <h2 class="text-2xl font-bold text-gray-800">Detail Penjualan</h2>
                        </div>
                        <p class="text-gray-500 text-sm md:ml-10">Informasi lengkap transaksi <span class="font-mono text-rns-blue font-semibold">{{ $penjualan->no_transaksi }}</span></p>
                    </div>
                    
                    <form action="{{ route('penjualan.destroy', $penjualan->id) }}" method="POST" id="delete-penjualan-form-{{ $penjualan->id }}">
                        @csrf @method('DELETE')
                        <button type="button" onclick="confirmDeletePenjualan('{{ $penjualan->id }}')" class="px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg font-medium text-sm transition-colors border border-red-200 shadow-sm flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus Data
                        </button>
                    </form>
                </div>

                <!-- Alerts -->
                @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm mb-6">
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
                @endif
                @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm mb-6">
                    <ul class="list-disc list-inside text-red-700 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Left Column: Transaction Details -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- Customer Info Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="p-5 border-b border-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <h3 class="font-bold text-gray-800">Informasi Pelanggan</h3>
                            </div>
                            <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-6">
                                <div>
                                    <div class="text-xs text-gray-500 mb-1">Nama Customer / Instansi</div>
                                    <div class="font-semibold text-gray-800">{{ $penjualan->nama_customer }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 mb-1">Nomor HP / WhatsApp</div>
                                    <div class="font-medium text-gray-800">{{ $penjualan->no_hp_customer ?? '-' }}</div>
                                </div>
                                <div class="md:col-span-2">
                                    <div class="text-xs text-gray-500 mb-1">Alamat Pengiriman</div>
                                    <div class="text-sm text-gray-800">{{ $penjualan->alamat_customer ?? '-' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Items Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    <h3 class="font-bold text-gray-800">Detail Barang Pembelian</h3>
                                </div>
                                <div class="text-sm text-gray-500">{{ $penjualan->tanggal_transaksi->format('d F Y') }}</div>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead class="bg-gray-50/50 text-xs text-gray-500 border-b border-gray-100">
                                        <tr>
                                            <th class="py-3 px-4 font-medium">No</th>
                                            <th class="py-3 px-4 font-medium">Nama Barang</th>
                                            <th class="py-3 px-4 font-medium text-center">Kuantitas</th>
                                            <th class="py-3 px-4 font-medium text-right">Harga Satuan</th>
                                            <th class="py-3 px-4 font-medium text-right">Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($penjualan->items as $idx => $item)
                                        <tr class="text-sm">
                                            <td class="py-3 px-4 text-gray-500">{{ $idx + 1 }}</td>
                                            <td class="py-3 px-4 font-medium text-gray-800">{{ $item->barang->name ?? 'Barang Terhapus' }}</td>
                                            <td class="py-3 px-4 text-center">{{ $item->kuantitas }}</td>
                                            <td class="py-3 px-4 text-right">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                            <td class="py-3 px-4 text-right font-semibold">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-5 bg-gray-50/30 border-t border-gray-100 flex flex-col items-end space-y-2">
                                <!-- Ongkir Info if any -->
                                @if($penjualan->is_ongkir_aktif)
                                <div class="w-full max-w-sm flex justify-between text-sm">
                                    <span class="text-gray-500">Subtotal Barang</span>
                                    <span class="font-medium text-gray-800">Rp {{ number_format($penjualan->total_keseluruhan - $penjualan->total_ongkir, 0, ',', '.') }}</span>
                                </div>
                                <div class="w-full max-w-sm flex justify-between text-sm">
                                    <span class="text-gray-500">Ongkos Kirim ({{ $penjualan->berat_total }}kg)</span>
                                    <span class="font-medium text-emerald-600">+ Rp {{ number_format($penjualan->total_ongkir, 0, ',', '.') }}</span>
                                </div>
                                @endif
                                <div class="w-full max-w-sm flex justify-between items-center border-t border-gray-200 mt-2 pt-2">
                                    <span class="font-bold text-gray-700">Total Keseluruhan</span>
                                    <span class="text-xl font-black text-rns-blue">Rp {{ number_format($penjualan->total_keseluruhan, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Fitur Cicilan (Moved to Left Column) -->
                        @if($penjualan->status_pembayaran === 'cicilan' || ($penjualan->status_pembayaran === 'lunas' && $penjualan->tenor_bulan))
                        <div class="bg-white rounded-xl shadow-sm border border-amber-100 overflow-hidden mt-6">
                            <div class="p-5 border-b border-amber-100 flex items-center justify-between bg-amber-50">
                                <h3 class="font-bold text-amber-900 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Manajemen Cicilan
                                </h3>
                                @if($penjualan->tenor_bulan)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-white text-amber-800 border border-amber-200">
                                        Tenor: {{ $penjualan->tenor_bulan }} Bulan
                                    </span>
                                @endif
                            </div>
                            
                            <div class="p-5">
                                @if(!$penjualan->tenor_bulan)
                                    <!-- Form Atur Tenor -->
                                    <form action="{{ route('penjualan.setTenor', $penjualan->id) }}" method="POST" class="mb-4">
                                        @csrf
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Uang Muka (DP) Rp:</label>
                                                <input type="number" name="dp_nominal" min="0" placeholder="0 (Opsional)" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-amber-500 focus:border-amber-500 bg-white">
                                                <p class="text-[10px] text-gray-500 mt-1">Isi jika pelanggan langsung membayar DP.</p>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Penandatangan DP:</label>
                                                <select name="penandatangan_dp" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm bg-white">
                                                    <option value="Dewi Sulistiowati">Dewi Sulistiowati</option>
                                                    <option value="Heri Pirdaus, S.Tr.Kes Rad (MRI)">Heri Pirdaus</option>
                                                </select>
                                                <p class="text-[10px] text-gray-500 mt-1">Siapa yang menandatangani kwitansi Uang Muka.</p>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Jangka Waktu (Bulan):</label>
                                                <div class="flex gap-2">
                                                    <input type="number" name="tenor_bulan" min="1" max="60" required placeholder="Tenor" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-amber-500 focus:border-amber-500 bg-white">
                                                    <button type="submit" class="py-2 px-4 bg-amber-600 text-white rounded-lg hover:bg-amber-700 font-medium text-sm transition-colors shadow-sm whitespace-nowrap">
                                                        Simpan
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    @php
                                        $totalDibayar = $penjualan->kwitansis()->sum('total_pembayaran');
                                        $sisaTagihan = $penjualan->total_keseluruhan - $totalDibayar;
                                        $persentase = $penjualan->total_keseluruhan > 0 ? ($totalDibayar / $penjualan->total_keseluruhan) * 100 : 0;
                                        
                                        $kwitansis = $penjualan->kwitansis()->orderBy('id')->get();
                                        $dpKwitansi = $kwitansis->first(function($k) { return str_contains(strtolower($k->keterangan), 'dp'); });
                                        $dp = $dpKwitansi ? $dpKwitansi->total_pembayaran : 0;
                                        $cicilanKwitansis = $kwitansis->filter(function($k) { return !str_contains(strtolower($k->keterangan), 'dp'); })->values();
                                        
                                        $estimasiPerBulan = $penjualan->tenor_bulan > 0 ? ($penjualan->total_keseluruhan - $dp) / $penjualan->tenor_bulan : 0;
                                        $dibayarCicilanSaja = $cicilanKwitansis->sum('total_pembayaran');
                                    @endphp
                                    
                                    <!-- Progress Bar -->
                                    <div class="mb-5">
                                        <div class="flex justify-between text-xs font-medium mb-1">
                                            <span class="text-gray-500">Progress Pembayaran</span>
                                            <span class="text-amber-700">{{ number_format($persentase, 1) }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-amber-500 h-2 rounded-full" style="width: {{ $persentase }}%"></div>
                                        </div>
                                    </div>
                                    
                                    <!-- Ringkasan Nominal -->
                                    <div class="grid grid-cols-2 gap-3 mb-4">
                                        <div class="bg-gray-50 border border-gray-100 p-3 rounded-lg">
                                            <div class="text-[10px] uppercase font-bold text-gray-500">Sudah Dibayar</div>
                                            <div class="text-sm font-bold text-green-600">Rp {{ number_format($totalDibayar, 0, ',', '.') }}</div>
                                        </div>
                                        <div class="bg-gray-50 border border-gray-100 p-3 rounded-lg">
                                            <div class="text-[10px] uppercase font-bold text-gray-500">Sisa Tagihan</div>
                                            <div class="text-sm font-bold text-red-600">Rp {{ number_format(max(0, $sisaTagihan), 0, ',', '.') }}</div>
                                        </div>
                                    </div>
                                    
                                    <hr class="border-gray-100 my-4">
                                    
                                    <!-- Jadwal & Riwayat Pembayaran -->
                                    <div class="mb-5">
                                        <div class="text-xs font-bold text-gray-700 uppercase mb-3 flex items-center justify-between">
                                            <span>Jadwal & Riwayat Cicilan</span>
                                        </div>
                                        
                                        <div class="space-y-3">
                                            {{-- Baris khusus DP jika ada --}}
                                            @if($dpKwitansi)
                                            <div class="bg-green-50 border border-green-200 rounded-lg p-3 text-sm flex justify-between items-center group relative">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-6 h-6 rounded-full bg-green-500 text-white flex items-center justify-center">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    </div>
                                                    <div>
                                                        <div class="font-bold text-green-800">Uang Muka (DP) : Rp {{ number_format($dpKwitansi->total_pembayaran, 0, ',', '.') }}</div>
                                                        <div class="text-[11px] text-green-600">{{ \Carbon\Carbon::parse($dpKwitansi->tanggal_kwitansi)->format('d/m/Y') }} &bull; {{ $dpKwitansi->nomor_kwitansi }}</div>
                                                    </div>
                                                </div>
                                                <a href="{{ route('kwitansi.print', $dpKwitansi->id) }}" target="_blank" class="text-green-600 hover:text-green-800 p-1.5 rounded transition-colors" title="Cetak Kwitansi DP">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                                </a>
                                            </div>
                                            @endif

                                            {{-- Generate schedule rows up to tenor_bulan --}}
                                            @php 
                                                // Keep track of how much of the (total - DP) is still "unallocated" across the loop
                                                $sisaPokokAlokasi = $penjualan->total_keseluruhan - $dp;
                                                $akumulasiAlokasiLalu = 0;
                                            @endphp
                                            @for($i = 0; $i < $penjualan->tenor_bulan; $i++)
                                                @php
                                                    $isPaid = isset($cicilanKwitansis[$i]);
                                                    $kwitansi = $isPaid ? $cicilanKwitansis[$i] : null;
                                                    
                                                    // Jika sudah lunas tapi sisa bulan tidak ada pembayarannya (karena bayar dipercepat misal), 
                                                    // jangan tampilkan form bayar, tampilkan label lunas
                                                    $isLunas = $penjualan->status_pembayaran === 'lunas';
                                                    
                                                    // Estimasi tgl jatuh tempo (perhitungan dari tgl transaksi + bulan ke-N)
                                                    $estimasiTgl = \Carbon\Carbon::parse($penjualan->created_at)->addMonths($i + 1)->format('d/m/Y');
                                                    
                                                    // Base case: normally you pay the estimated per month
                                                    $alokasiBulanIni = ceil($estimasiPerBulan);
                                                    
                                                    // Final month case: pay whatever is truly remaining from the allocation
                                                    if ($i === $penjualan->tenor_bulan - 1) {
                                                        $alokasiBulanIni = $sisaPokokAlokasi - $akumulasiAlokasiLalu;
                                                    }
                                                    
                                                    // Update tracking explicitly 
                                                    $akumulasiAlokasiLalu += $alokasiBulanIni;
                                                    
                                                    $nominalBulanIni = $alokasiBulanIni;
                                                    if ($isPaid) {
                                                        $nominalBulanIni = $kwitansi->total_pembayaran;
                                                    }
                                                @endphp
                                                
                                                @if($isPaid)
                                                <div class="bg-green-50 border border-green-200 rounded-lg p-3 text-sm flex justify-between items-center group relative">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-6 h-6 rounded-full bg-green-500 text-white flex items-center justify-center">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                        </div>
                                                        <div>
                                                            <div class="font-bold text-green-800">Bulan Ke-{{ $i + 1 }} Lunas : Rp {{ number_format($kwitansi->total_pembayaran, 0, ',', '.') }}</div>
                                                            <div class="text-[11px] text-green-600">{{ \Carbon\Carbon::parse($kwitansi->tanggal_kwitansi)->format('d/m/Y') }} &bull; {{ $kwitansi->nomor_kwitansi }}</div>
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('kwitansi.print', $kwitansi->id) }}" target="_blank" class="text-green-600 hover:text-green-800 p-1.5 rounded transition-colors" title="Cetak Kwitansi Cicilan">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                                    </a>
                                                </div>
                                                @elseif(!$isPaid && !$isLunas)
                                                <div class="bg-white border border-gray-200 rounded-lg p-3 text-sm flex justify-between items-center">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-6 h-6 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center font-bold text-xs">
                                                            {{ $i + 1 }}
                                                        </div>
                                                        <div>
                                                            <div class="font-bold text-gray-700">Tagihan Ke-{{ $i + 1 }} : Rp {{ number_format($nominalBulanIni, 0, ',', '.') }}</div>
                                                            <div class="text-[11px] text-gray-500 flex items-center gap-1">
                                                                <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 
                                                                Estimasi Jatuh Tempo: {{ $estimasiTgl }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <form action="{{ route('penjualan.storeCicilan', $penjualan->id) }}" method="POST" id="bayar-cicilan-form-{{ $i }}" class="flex gap-1.5 items-center">
                                                        @csrf
                                                        <input type="hidden" name="tanggal_kwitansi" value="{{ date('Y-m-d') }}">
                                                        <input type="hidden" name="total_pembayaran" value="{{ $nominalBulanIni }}">
                                                        <input type="hidden" name="keterangan" value="Pembayaran Cicilan Ke-{{ $i + 1 }}">
                                                        <select name="penandatangan" class="w-28 bg-white rounded border-gray-200 border px-2 py-1 text-[11px] focus:ring-amber-500 focus:border-amber-500" required>
                                                            <option value="Dewi Sulistiowati">Dewi S.</option>
                                                            <option value="Heri Pirdaus, S.Tr.Kes Rad (MRI)">Heri P.</option>
                                                        </select>
                                                        <button type="button" onclick="confirmBayarCicilan('{{ $i }}', '{{ $i + 1 }}', 'Rp {{ number_format($nominalBulanIni, 0, ',', '.') }}')" class="text-xs bg-amber-500 hover:bg-amber-600 text-white font-bold py-1 px-3 rounded shadow-sm transition-colors cursor-pointer">
                                                            Bayar
                                                        </button>
                                                    </form>
                                                </div>
                                                @elseif(!$isPaid && $isLunas)
                                                <!-- Empty block, Lunas but array elements are empty -->
                                                @endif
                                            @endfor
                                        </div>
                                    </div>

                                @endif
                            </div>
                        </div>
                        @endif

                    </div>

                    <!-- Right Column: Actions -->
                    <div class="space-y-6">
                        
                        <!-- Status Pembayaran -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Status Pembayaran
                                </h3>
                                <div>
                                    @if($penjualan->status_pembayaran === 'lunas')
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-green-100 text-green-800 uppercase tracking-wider">Lunas</span>
                                    @elseif($penjualan->status_pembayaran === 'cicilan')
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-amber-100 text-amber-800 uppercase tracking-wider">Cicilan</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-red-100 text-red-800 uppercase tracking-wider">Belum Lunas</span>
                                    @endif
                                </div>
                            </div>
                            <div class="p-5 bg-gray-50/50">
                                @if($penjualan->status_pembayaran === 'lunas')
                                    <div class="text-sm text-center text-green-700 font-medium py-3 border border-green-200 bg-green-50 rounded-lg">
                                        Transaksi ini telah lunas dan statusnya tidak dapat diubah lagi.
                                    </div>
                                @else
                                <form action="{{ route('penjualan.updateStatus', $penjualan->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Update Status Baru:</label>
                                    <select name="status_pembayaran" id="statusPembayaranUpdate" onchange="toggleSignatoryUpdate()" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white mb-3">
                                        <option value="belum lunas" {{ $penjualan->status_pembayaran == 'belum lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                        <option value="cicilan" {{ $penjualan->status_pembayaran == 'cicilan' ? 'selected' : '' }}>Cicilan / Termin</option>
                                        <option value="lunas" {{ $penjualan->status_pembayaran == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                    </select>

                                    <div id="signatoryUpdateField" class="hidden mb-3">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Penandatangan Kwitansi Lunas:</label>
                                        <select name="penandatangan" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white">
                                            <option value="Dewi Sulistiowati">Dewi Sulistiowati</option>
                                            <option value="Heri Pirdaus, S.Tr.Kes Rad (MRI)">Heri Pirdaus</option>
                                        </select>
                                        <p class="text-[10px] text-indigo-600 mt-1">*Kwitansi lunas akan dibuat otomatis saat status disimpan.</p>
                                    </div>

                                    <button type="submit" class="w-full py-2 bg-gray-800 text-white rounded-lg hover:bg-black font-medium text-sm transition-colors shadow-sm">
                                        Simpan Perubahan
                                    </button>
                                </form>

                                <script>
                                    function toggleSignatoryUpdate() {
                                        const status = document.getElementById('statusPembayaranUpdate').value;
                                        const field = document.getElementById('signatoryUpdateField');
                                        if (status === 'lunas') {
                                            field.classList.remove('hidden');
                                        } else {
                                            field.classList.add('hidden');
                                        }
                                    }
                                    // Run on load
                                    document.addEventListener('DOMContentLoaded', toggleSignatoryUpdate);
                                </script>
                                @endif
                            </div>
                        </div>



                        <!-- Cetak Dokumen Terkait -->
                        <div class="bg-indigo-50 border border-indigo-100 rounded-xl shadow-sm overflow-hidden mb-6">
                            <div class="p-5 border-b border-indigo-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <h3 class="font-bold text-indigo-900">Buat Dokumen Penjualan</h3>
                            </div>
                            <div class="p-5">
                                <form action="{{ route('invoice.store') }}" method="POST" class="mb-3">
                                    @csrf
                                    <input type="hidden" name="penjualan_id" value="{{ $penjualan->id }}">
                                    <input type="hidden" name="tanggal_invoice" value="{{ date('Y-m-d') }}">
                                    
                                    <div class="mb-2">
                                        <textarea name="keterangan" rows="2" class="w-full rounded-lg border-indigo-200 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white" placeholder="Keterangan / Catatan Bank...">Pembayaran Bisa Di Tranfer Melalui Rek Bank BSI (BANK SYARIAH INDONESIA) :
No Rek : 1101198975
Atas Nama : PT RANAY NUSANTARA SEJAHTERA
Kode bank : 451</textarea>
                                    </div>
                                    <div class="flex gap-2">
                                        <select name="penandatangan" class="w-full rounded-lg border-indigo-200 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                                            <option value="Dewi Sulistiowati">Dewi Sulistiowati</option>
                                            <option value="Heri Pirdaus, S.Tr.Kes Rad (MRI)">Heri Pirdaus</option>
                                        </select>
                                        <button type="submit" class="w-full py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold text-sm transition-colors shadow-md">
                                            + Invoice
                                        </button>
                                    </div>
                                </form>

                                <form action="{{ route('kwitansi.store') }}" method="POST" class="mb-3">
                                    @csrf
                                    <input type="hidden" name="penjualan_id" value="{{ $penjualan->id }}">
                                    <input type="hidden" name="tanggal_kwitansi" value="{{ date('Y-m-d') }}">
                                    <input type="hidden" name="nama_penerima" value="{{ $penjualan->nama_customer }}">
                                    <input type="hidden" name="alamat_penerima" value="{{ $penjualan->alamat_customer }}">
                                    <input type="hidden" name="total_pembayaran" value="{{ $penjualan->total_keseluruhan }}">
                                    <input type="hidden" name="keterangan" value="Pembayaran Transaksi {{ $penjualan->no_transaksi }}">
                                    <input type="hidden" name="total_bilangan" value="(Silakan Edit Nanti Jika Perlu)">
                                    
                                    <div class="flex gap-2">
                                        <select name="penandatangan" class="w-full rounded-lg border-indigo-200 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                                            <option value="Dewi Sulistiowati">Dewi Sulistiowati</option>
                                            <option value="Heri Pirdaus, S.Tr.Kes Rad (MRI)">Heri Pirdaus</option>
                                        </select>
                                        <button type="submit" class="w-full py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold text-sm transition-colors shadow-md">
                                            + Kwitansi
                                        </button>
                                    </div>
                                </form>

                                <form action="{{ route('surat-jalan.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="penjualan_id" value="{{ $penjualan->id }}">
                                    <input type="hidden" name="tanggal_surat_jalan" value="{{ date('Y-m-d') }}">
                                    <input type="hidden" name="nama_pengirim" value="PT Rand Nusantara Sejahtera">
                                    <input type="hidden" name="nama_penerima" value="{{ $penjualan->nama_customer }}">
                                    <input type="hidden" name="telp_penerima" value="{{ $penjualan->no_hp_customer ?? '-' }}">
                                    <input type="hidden" name="alamat_penerima" value="{{ $penjualan->alamat_customer }}">
                                    <input type="hidden" name="nama_barang_jasa" value="Barang/Jasa Sesuai Pesanan">
                                    <input type="hidden" name="qty" value="{{ $penjualan->items->sum('kuantitas') }}">
                                    <input type="hidden" name="jumlah" value="{{ $penjualan->total_keseluruhan }}">
                                    <input type="hidden" name="keterangan" value="-">
                                    <button type="submit" class="flex w-full justify-center py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 font-semibold text-sm transition-colors shadow-md">
                                        + Surat Jalan
                                    </button>
                                </form>
                                <p class="text-[11px] text-indigo-700 mt-3 leading-relaxed text-center">Buat dokumen pendukung otomatis dari data transaksi saat ini. Detail lebih lanjut dapat diedit di menu masing-masing.</p>
                            </div>
                        </div>

                        <!-- Daftar Dokumen Tersimpan -->
                        @if($penjualan->invoices->count() > 0 || $penjualan->kwitansis->count() > 0 || $penjualan->suratJalans->count() > 0)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Dokumen Terbit
                                </h3>
                            </div>
                            <div class="divide-y divide-gray-100">
                                
                                {{-- Invoice List --}}
                                @foreach($penjualan->invoices as $inv)
                                <div class="p-4 hover:bg-gray-50 transition-colors flex items-center justify-between group">
                                    <div>
                                        <div class="text-xs font-bold text-indigo-600 uppercase mb-0.5">Invoice</div>
                                        <div class="text-sm font-semibold text-gray-800">{{ $inv->no_invoice }}</div>
                                        <div class="text-[11px] text-gray-500 mt-0.5">Tgl: {{ \Carbon\Carbon::parse($inv->tanggal_invoice)->format('d/m/Y') }}</div>
                                    </div>
                                    <div class="flex items-center gap-1 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('invoice.print', $inv->id) }}" target="_blank" class="p-1.5 text-blue-600 hover:bg-blue-100 rounded" title="Cetak PDF">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        <form action="{{ route('invoice.destroy', $inv->id) }}" method="POST" id="delete-invoice-form-{{ $inv->id }}" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDeleteDoc('invoice', '{{ $inv->id }}')" class="p-1.5 text-red-600 hover:bg-red-100 rounded" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach

                                {{-- Kwitansi List --}}
                                @foreach($penjualan->kwitansis as $kwt)
                                <div class="p-4 hover:bg-gray-50 transition-colors flex items-center justify-between group">
                                    <div>
                                        <div class="text-xs font-bold text-green-600 uppercase mb-0.5">Kwitansi</div>
                                        <div class="text-sm font-semibold text-gray-800">{{ $kwt->nomor_kwitansi }}</div>
                                        <div class="text-[11px] text-gray-500 mt-0.5">Tgl: {{ \Carbon\Carbon::parse($kwt->tanggal_kwitansi)->format('d/m/Y') }}</div>
                                    </div>
                                    <div class="flex items-center gap-1 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('kwitansi.print', $kwt->id) }}" target="_blank" class="p-1.5 text-blue-600 hover:bg-blue-100 rounded" title="Cetak PDF">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        <form action="{{ route('kwitansi.destroy', $kwt->id) }}" method="POST" id="delete-kwitansi-form-{{ $kwt->id }}" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDeleteDoc('kwitansi', '{{ $kwt->id }}')" class="p-1.5 text-red-600 hover:bg-red-100 rounded" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach

                                {{-- Surat Jalan List --}}
                                @foreach($penjualan->suratJalans as $sj)
                                <div class="p-4 hover:bg-gray-50 transition-colors flex items-center justify-between group">
                                    <div>
                                        <div class="text-xs font-bold text-amber-600 uppercase mb-0.5">Surat Jalan</div>
                                        <div class="text-sm font-semibold text-gray-800">{{ $sj->nomor_surat_jalan }}</div>
                                        <div class="text-[11px] text-gray-500 mt-0.5">Tgl: {{ \Carbon\Carbon::parse($sj->tanggal_surat_jalan)->format('d/m/Y') }}</div>
                                    </div>
                                    <div class="flex items-center gap-1 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('surat-jalan.print', $sj->id) }}" target="_blank" class="p-1.5 text-blue-600 hover:bg-blue-100 rounded" title="Cetak PDF">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        <form action="{{ route('surat-jalan.destroy', $sj->id) }}" method="POST" id="delete-surat-jalan-form-{{ $sj->id }}" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDeleteDoc('surat-jalan', '{{ $sj->id }}')" class="p-1.5 text-red-600 hover:bg-red-100 rounded" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                        @endif

                    </div>

                </div>

            </div>
        </div>
    </main>
    </main>

    <!-- Modal Tambah Cicilan -->
    @if($penjualan->status_pembayaran === 'cicilan' && $penjualan->tenor_bulan)
    <div id="modalTambahCicilan" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('modalTambahCicilan').classList.add('hidden')"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <form action="{{ route('penjualan.storeCicilan', $penjualan->id) }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-amber-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                                    Catat Pembayaran Cicilan
                                </h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembayaran <span class="text-red-500">*</span></label>
                                        <input type="date" name="tanggal_kwitansi" value="{{ date('Y-m-d') }}" required class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-amber-500 focus:border-amber-500 bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Penandatangan Kwitansi <span class="text-red-500">*</span></label>
                                        <select name="penandatangan" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-amber-500 focus:border-amber-500 bg-white" required>
                                            <option value="Dewi Sulistiowati">Dewi Sulistiowati</option>
                                            <option value="Heri Pirdaus, S.Tr.Kes Rad (MRI)">Heri Pirdaus</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nominal Pembayaran (Rp) <span class="text-red-500">*</span></label>
                                        <input type="number" name="total_pembayaran" min="1" required placeholder="0" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-amber-500 focus:border-amber-500 bg-white">
                                        @php
                                            $totalDibayar = $penjualan->kwitansis()->sum('total_pembayaran');
                                            $sisaTagihan = $penjualan->total_keseluruhan - $totalDibayar;
                                        @endphp
                                        <p class="text-xs text-gray-500 mt-1">Sisa tagihan saat ini: Rp {{ number_format(max(0, $sisaTagihan), 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan (Opsional)</label>
                                        <textarea name="keterangan" rows="2" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-amber-500 focus:border-amber-500 bg-white" placeholder="Contoh: Cicilan bulan pertama..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-amber-600 text-base font-medium text-white hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Simpan Cicilan
                        </button>
                        <button type="button" onclick="document.getElementById('modalTambahCicilan').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <script>
        function confirmDeletePenjualan(id) {
            Swal.fire({
                title: 'Hapus Data Penjualan?',
                text: 'Yakin ingin menghapus data penjualan INI? Stok barang akan dikembalikan utuh ke dalam sistem.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Hapus Data',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-penjualan-form-' + id).submit();
                }
            });
        }

        function confirmBayarCicilan(index, ke, nominal) {
            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: `Proses pembayaran tagihan ke-${ke} senilai ${nominal}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Bayar',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('bayar-cicilan-form-' + index).submit();
                }
            });
        }

        function confirmDeleteDoc(type, id) {
            let label = '';
            if (type === 'invoice') label = 'invoice';
            else if (type === 'kwitansi') label = 'kwitansi';
            else if (type === 'surat-jalan') label = 'surat jalan';

            Swal.fire({
                title: `Hapus record ${label}?`,
                text: `Tindakan ini akan menghapus dokumen ${label} terkait.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-${type}-form-` + id).submit();
                }
            });
        }
    </script>
</body>
</html>
