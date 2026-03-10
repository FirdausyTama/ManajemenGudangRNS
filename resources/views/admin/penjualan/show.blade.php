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
                    
                    <form action="{{ route('penjualan.destroy', $penjualan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data penjualan INI? Stok barang akan dikembalikan utuh ke dalam sistem.');">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg font-medium text-sm transition-colors border border-red-200 shadow-sm flex items-center gap-1.5">
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
                                <form action="{{ route('penjualan.updateStatus', $penjualan->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Update Status Baru:</label>
                                    <select name="status_pembayaran" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white mb-3">
                                        <option value="belum lunas" {{ $penjualan->status_pembayaran == 'belum lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                        <option value="cicilan" {{ $penjualan->status_pembayaran == 'cicilan' ? 'selected' : '' }}>Cicilan / Termin</option>
                                        <option value="lunas" {{ $penjualan->status_pembayaran == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                    </select>
                                    <button type="submit" class="w-full py-2 bg-gray-800 text-white rounded-lg hover:bg-black font-medium text-sm transition-colors shadow-sm">
                                        Simpan Perubahan
                                    </button>
                                </form>
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
                                    <input type="hidden" name="nama_pengirim" value="PT Ranay Nusantara Sejahtera">
                                    <input type="hidden" name="nama_penerima" value="{{ $penjualan->nama_customer }}">
                                    <input type="hidden" name="telp_penerima" value="{{ $penjualan->no_hp_customer ?? '-' }}">
                                    <input type="hidden" name="alamat_penerima" value="{{ $penjualan->alamat_customer }}">
                                    <input type="hidden" name="nama_barang_jasa" value="Barang/Jasa Sesuai Pesanan">
                                    <input type="hidden" name="qty" value="{{ count($penjualan->items) }}">
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
                                        <form action="{{ route('invoice.destroy', $inv->id) }}" method="POST" onsubmit="return confirm('Hapus record invoice ini?');" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 text-red-600 hover:bg-red-100 rounded" title="Hapus">
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
                                        <form action="{{ route('kwitansi.destroy', $kwt->id) }}" method="POST" onsubmit="return confirm('Hapus record kwitansi ini?');" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 text-red-600 hover:bg-red-100 rounded" title="Hapus">
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
                                        <form action="{{ route('surat-jalan.destroy', $sj->id) }}" method="POST" onsubmit="return confirm('Hapus record surat jalan ini?');" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 text-red-600 hover:bg-red-100 rounded" title="Hapus">
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

    <script>
        // Sidebar logic 
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const topbar = document.getElementById('topbar');
            const toggleBtn = document.getElementById('sidebar-toggle-btn');
            const overlay = document.getElementById('sidebar-overlay');

            function toggleSidebar() {
                const isMobile = window.innerWidth < 768;
                
                if (isMobile) {
                    sidebar.classList.toggle('-translate-x-full');
                    if (sidebar.classList.contains('-translate-x-full')) {
                        if (overlay) overlay.classList.add('hidden');
                    } else {
                        if (overlay) overlay.classList.remove('hidden');
                    }
                } else {
                    sidebar.classList.toggle('md:-translate-x-full');
                    sidebar.classList.toggle('md:translate-x-0');
                    
                    if (mainContent) {
                        mainContent.classList.toggle('md:ml-64');
                        mainContent.classList.toggle('md:ml-0');
                    }
                    
                    if (topbar) {
                        topbar.classList.toggle('md:left-64');
                        topbar.classList.toggle('md:left-0');
                    }
                }
            }

            if (toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
            if (overlay) overlay.addEventListener('click', toggleSidebar);

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) {
                    if (overlay) overlay.classList.add('hidden');
                } else {
                    if (sidebar && !sidebar.classList.contains('-translate-x-full')) {
                        if (overlay) overlay.classList.remove('hidden');
                    }
                }
            });
        });
    </script>
</body>
</html>
