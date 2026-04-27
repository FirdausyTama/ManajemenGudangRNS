<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Keuntungan | Rand Nusantara Sejahtera</title>

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
            <div class="max-w-7xl mx-auto space-y-6 relative z-10">
                
                <!-- Page Header -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Laporan Keuntungan</h2>
                        <p class="text-gray-500 text-sm mt-1">Pantau performa penjualan dan profitabilitas bisnis Anda.</p>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-200 mb-6">
                    <form action="{{ route('laporan-keuntungan.index') }}" method="GET" class="space-y-6">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-end">
                            
                            <!-- Preset Filter -->
                            <div class="lg:col-span-5 w-full">
                                <label class="block text-[10px] font-bold text-gray-400 mb-2 uppercase tracking-widest">Preset Rentang Waktu</label>
                                <div class="grid grid-cols-2 sm:flex sm:flex-wrap gap-2">
                                    <a href="{{ route('laporan-keuntungan.index', ['filter' => 'day', 'barang_id' => $barangId]) }}" class="text-center px-3 py-2.5 rounded-lg text-xs font-bold transition-all {{ $filter == 'day' && !request('start_date') ? 'bg-rns-blue text-white shadow-md shadow-blue-100' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 border border-gray-200' }}">Hari Ini</a>
                                    <a href="{{ route('laporan-keuntungan.index', ['filter' => 'week', 'barang_id' => $barangId]) }}" class="text-center px-3 py-2.5 rounded-lg text-xs font-bold transition-all {{ $filter == 'week' ? 'bg-rns-blue text-white shadow-md shadow-blue-100' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 border border-gray-200' }}">Minggu Ini</a>
                                    <a href="{{ route('laporan-keuntungan.index', ['filter' => 'month', 'barang_id' => $barangId]) }}" class="text-center px-3 py-2.5 rounded-lg text-xs font-bold transition-all {{ $filter == 'month' ? 'bg-rns-blue text-white shadow-md shadow-blue-100' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 border border-gray-200' }}">Bulan Ini</a>
                                    <a href="{{ route('laporan-keuntungan.index', ['filter' => 'year', 'barang_id' => $barangId]) }}" class="text-center px-3 py-2.5 rounded-lg text-xs font-bold transition-all {{ $filter == 'year' ? 'bg-rns-blue text-white shadow-md shadow-blue-100' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 border border-gray-200' }}">Tahun Ini</a>
                                </div>
                            </div>

                            <!-- Product Filter -->
                            <div class="lg:col-span-3 w-full">
                                <label class="block text-[10px] font-bold text-gray-400 mb-2 uppercase tracking-widest">Filter Barang</label>
                                <div class="relative">
                                    <select name="barang_id" onchange="this.form.submit()" class="w-full appearance-none rounded-lg border-gray-300 border px-4 py-2.5 text-xs font-bold focus:ring-2 focus:ring-rns-blue/10 focus:border-rns-blue bg-white transition-all">
                                        <option value="">Semua Barang</option>
                                        @foreach($barangs as $b)
                                            <option value="{{ $b->id }}" {{ $barangId == $b->id ? 'selected' : '' }}>{{ $b->sku }} - {{ $b->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                                <input type="hidden" name="filter" value="{{ $filter }}">
                            </div>

                            <!-- Custom Date Range -->
                            <div class="lg:col-span-4 w-full">
                                <label class="block text-[10px] font-bold text-gray-400 mb-2 uppercase tracking-widest">Rentang Tanggal Kustom</label>
                                <div class="flex flex-col sm:flex-row items-center gap-3">
                                    <div class="flex items-center gap-1.5 flex-1 w-full sm:w-auto">
                                        <input type="date" name="start_date" value="{{ $startDate }}" class="flex-1 min-w-0 rounded-lg border-gray-300 border px-2 py-2 text-[11px] font-bold focus:ring-2 focus:ring-rns-blue/10 focus:border-rns-blue transition-all">
                                        <span class="text-gray-400 text-[10px] font-black shrink-0">s/d</span>
                                        <input type="date" name="end_date" value="{{ $endDate }}" class="flex-1 min-w-0 rounded-lg border-gray-300 border px-2 py-2 text-[11px] font-bold focus:ring-2 focus:ring-rns-blue/10 focus:border-rns-blue transition-all">
                                    </div>
                                    <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-rns-blue text-white rounded-lg hover:bg-blue-800 transition-all shadow-md shadow-blue-100 flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        <span class="lg:hidden text-[10px] font-bold uppercase tracking-wider">Cari</span>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6">
                    <div class="bg-white p-5 md:p-6 rounded-xl shadow-sm border border-gray-200">
                        <div class="text-gray-500 text-[10px] md:text-xs font-bold uppercase tracking-widest mb-1">Total Barang Keluar</div>
                        <div class="text-2xl md:text-3xl font-bold text-gray-800">{{ number_format($summary['total_items_sold'], 0, ',', '.') }} Item</div>
                        <div class="mt-2 text-[10px] md:text-xs text-blue-600 bg-blue-50 font-medium inline-block px-2 py-0.5 rounded">Volume Penjualan</div>
                    </div>
                    <div class="bg-white p-5 md:p-6 rounded-xl shadow-sm border border-gray-200">
                        <div class="text-gray-500 text-[10px] md:text-xs font-bold uppercase tracking-widest mb-1">Total Modal</div>
                        <div class="text-xl md:text-2xl font-bold text-gray-800">Rp {{ number_format($summary['total_modal'], 0, ',', '.') }}</div>
                        <div class="mt-2 text-[10px] md:text-xs text-gray-400 font-medium bg-gray-50 px-2 py-0.5 rounded">Pengeluaran Stok</div>
                    </div>
                    <div class="bg-white p-5 md:p-6 rounded-xl shadow-sm border border-gray-200">
                        <div class="text-gray-500 text-[10px] md:text-xs font-bold uppercase tracking-widest mb-1">Total Pendapatan</div>
                        <div class="text-xl md:text-2xl font-bold text-gray-800">Rp {{ number_format($summary['total_pendapatan'], 0, ',', '.') }}</div>
                        <div class="mt-2 text-[10px] md:text-xs text-emerald-600 bg-emerald-50 font-medium inline-block px-2 py-0.5 rounded">Omzet Penjualan</div>
                    </div>
                    <div class="bg-white p-5 md:p-6 rounded-xl shadow-sm border border-emerald-100 bg-emerald-50/30">
                        <div class="text-emerald-700 text-[10px] md:text-xs font-bold uppercase tracking-widest mb-1">Total Keuntungan</div>
                        <div class="text-2xl md:text-3xl font-bold text-emerald-700">Rp {{ number_format($summary['total_keuntungan'], 0, ',', '.') }}</div>
                        <div class="mt-2 text-[10px] md:text-xs text-emerald-700 font-bold">Laba Kotor</div>
                    </div>
                </div>

                <!-- Data Table & Mobile Cards -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-4 border-b-2 border-gray-100 flex items-center justify-between bg-gray-50/50">
                        <h3 class="font-bold text-gray-800 uppercase tracking-tight">Rincian Barang Keluar & Keuntungan</h3>
                        <div class="text-xs text-gray-500 font-bold">Menampilkan {{ $reportData->firstItem() ?? 0 }} - {{ $reportData->lastItem() ?? 0 }} dari total {{ $reportData->total() }} data</div>
                    </div>
                    
                    <!-- Mobile Card View -->
                    <div class="block md:hidden divide-y-2 divide-gray-100">
                        @forelse ($reportData as $data)
                        <div class="p-4 space-y-3 hover:bg-gray-50 transition-colors">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="text-[10px] text-gray-400 font-bold uppercase line-clamp-1">{{ date('d/m/Y', strtotime($data['tanggal'])) }}</div>
                                    <div class="font-bold text-gray-800">{{ $data['barang'] }}</div>
                                    <div class="text-xs text-gray-500">{{ $data['no_transaksi'] }} | {{ $data['nama_customer'] }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs text-gray-400">Qty</div>
                                    <div class="font-bold text-rns-blue">{{ $data['qty'] }}</div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 pt-2 border-t border-gray-50">
                                <div>
                                    <div class="text-[10px] text-gray-400 uppercase font-bold">Total Jual</div>
                                    <div class="text-sm font-semibold text-gray-800">Rp {{ number_format($data['pendapatan_total'], 0, ',', '.') }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-[10px] text-gray-400 uppercase font-bold">Keuntungan</div>
                                    <div class="text-sm font-bold {{ $data['keuntungan_total'] >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                        Rp {{ number_format($data['keuntungan_total'], 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="py-10 text-center text-gray-400 text-sm">Tidak ada data.</div>
                        @endforelse
                    </div>

                    <!-- Desktop Table View -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b-2 border-gray-100 text-[11px] text-gray-500 uppercase tracking-widest">
                                    <th class="py-3 px-4 font-bold">Tanggal</th>
                                    <th class="py-3 px-4 font-bold">No Transaksi / Customer</th>
                                    <th class="py-3 px-4 font-bold">Nama Barang</th>
                                    <th class="py-3 px-4 font-bold text-center">Qty</th>
                                    <th class="py-3 px-4 font-bold">Harga Beli</th>
                                    <th class="py-3 px-4 font-bold">Harga Jual</th>
                                    <th class="py-3 px-4 font-bold">Total Modal</th>
                                    <th class="py-3 px-4 font-bold">Total Jual</th>
                                    <th class="py-3 px-4 font-bold text-right">Keuntungan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y-2 divide-gray-100 text-sm">
                                @forelse ($reportData as $data)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4 text-gray-600 whitespace-nowrap">
                                        {{ date('d/m/Y', strtotime($data['tanggal'])) }}
                                    </td>
                                    <td class="py-4 px-4 border-l border-gray-50">
                                        <div class="font-medium text-gray-800">{{ $data['no_transaksi'] }}</div>
                                        <div class="text-xs text-gray-500">{{ $data['nama_customer'] }}</div>
                                    </td>
                                    <td class="py-4 px-4 border-l border-gray-50">
                                        <div class="font-medium text-gray-700">{{ $data['barang'] }}</div>
                                    </td>
                                    <td class="py-4 px-4 border-l border-gray-50 text-center font-bold text-gray-800">
                                        {{ $data['qty'] }}
                                    </td>
                                    <td class="py-4 px-4 border-l border-gray-50 text-gray-500 italic">
                                        {{ number_format($data['harga_beli'], 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-4 border-l border-gray-50 text-blue-600 font-medium">
                                        {{ number_format($data['harga_jual'], 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-4 border-l border-gray-50 text-gray-500">
                                        {{ number_format($data['modal_total'], 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-4 border-l border-gray-50 text-gray-800 font-medium">
                                        {{ number_format($data['pendapatan_total'], 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-4 border-l border-gray-50 text-right">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold {{ $data['keuntungan_total'] >= 0 ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                                            {{ number_format($data['keuntungan_total'], 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="py-20 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                            <span class="text-gray-400 font-medium">Tidak ada data transaksi ditemukan.</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            @if($reportData->total() > 0)
                            <tfoot class="bg-gray-50 border-t-2 border-gray-100">
                                <tr class="font-bold text-gray-800">
                                    <td colspan="3" class="py-4 px-4 text-right">TOTAL KESELURUHAN:</td>
                                    <td class="py-4 px-4 text-center">{{ number_format($summary['total_items_sold'], 0, ',', '.') }}</td>
                                    <td colspan="2"></td>
                                    <td class="py-4 px-4">Rp {{ number_format($summary['total_modal'], 0, ',', '.') }}</td>
                                    <td class="py-4 px-4">Rp {{ number_format($summary['total_pendapatan'], 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 text-right">
                                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-black bg-emerald-600 text-white shadow-md border-2 border-emerald-700">
                                            Rp {{ number_format($summary['total_keuntungan'], 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                    @if($reportData->hasPages())
                    <div class="p-4 border-t border-gray-100 bg-white">
                        {{ $reportData->links('vendor.pagination.custom') }}
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </main>

    <script>

    </script>
</body>
</html>
