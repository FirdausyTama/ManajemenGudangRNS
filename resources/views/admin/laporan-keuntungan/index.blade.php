<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Keuntungan | Ranay Nusantara Sejathera</title>

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
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
                    <form action="{{ route('laporan-keuntungan.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
                        <div class="flex-1 w-full">
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">Preset Filter</label>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('laporan-keuntungan.index', ['filter' => 'day']) }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $filter == 'day' && !request('start_date') ? 'bg-rns-blue text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Hari Ini</a>
                                <a href="{{ route('laporan-keuntungan.index', ['filter' => 'week']) }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $filter == 'week' ? 'bg-rns-blue text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Minggu Ini</a>
                                <a href="{{ route('laporan-keuntungan.index', ['filter' => 'month']) }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $filter == 'month' ? 'bg-rns-blue text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Bulan Ini</a>
                                <a href="{{ route('laporan-keuntungan.index', ['filter' => 'year']) }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $filter == 'year' ? 'bg-rns-blue text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Tahun Ini</a>
                            </div>
                        </div>

                        <div class="w-full md:w-auto">
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">Rentang Tanggal Custom</label>
                            <div class="flex items-center gap-2">
                                <input type="date" name="start_date" value="{{ $startDate }}" class="rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue">
                                <span class="text-gray-400">-</span>
                                <input type="date" name="end_date" value="{{ $endDate }}" class="rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue">
                                <button type="submit" class="p-2 bg-rns-blue text-white rounded-lg hover:bg-blue-800 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <div class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-1">Total Barang Keluar</div>
                        <div class="text-2xl font-bold text-gray-800">{{ number_format($summary['total_items_sold'], 0, ',', '.') }} Item</div>
                        <div class="mt-2 text-xs text-blue-600 bg-blue-50 inline-block px-2 py-0.5 rounded">Volume Penjualan</div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <div class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-1">Total Modal (Harga Pabrik)</div>
                        <div class="text-2xl font-bold text-gray-800">Rp {{ number_format($summary['total_modal'], 0, ',', '.') }}</div>
                        <div class="mt-2 text-xs text-gray-400">Pengeluaran Stok</div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <div class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-1">Total Pendapatan</div>
                        <div class="text-2xl font-bold text-gray-800">Rp {{ number_format($summary['total_pendapatan'], 0, ',', '.') }}</div>
                        <div class="mt-2 text-xs text-emerald-600 bg-emerald-50 inline-block px-2 py-0.5 rounded">Omzet Penjualan</div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 bg-emerald-50/30">
                        <div class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-1">Total Keuntungan (Gross)</div>
                        <div class="text-2xl font-bold text-emerald-700">Rp {{ number_format($summary['total_keuntungan'], 0, ',', '.') }}</div>
                        <div class="mt-2 text-xs text-emerald-700 font-bold">Laba Kotor</div>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-4 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                        <h3 class="font-bold text-gray-800">Rincian Barang Keluar & Keuntungan</h3>
                        <div class="text-xs text-gray-500 font-medium">Menampilkan {{ count($reportData) }} Baris Data</div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100 text-xs text-gray-500 uppercase tracking-wider">
                                    <th class="py-3 px-4 font-bold">Tanggal</th>
                                    <th class="py-3 px-4 font-bold">No Transaksi / Customer</th>
                                    <th class="py-3 px-4 font-bold">Nama Barang</th>
                                    <th class="py-3 px-4 font-bold text-center">Qty</th>
                                    <th class="py-3 px-4 font-bold">Harga Beli (Modal)</th>
                                    <th class="py-3 px-4 font-bold">Harga Jual</th>
                                    <th class="py-3 px-4 font-bold">Total Modal</th>
                                    <th class="py-3 px-4 font-bold">Total Jual</th>
                                    <th class="py-3 px-4 font-bold text-right">Keuntungan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm">
                                @forelse ($reportData as $data)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3 px-4 text-gray-600 whitespace-nowrap">
                                        {{ date('d/m/Y', strtotime($data['tanggal'])) }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="font-medium text-gray-800">{{ $data['no_transaksi'] }}</div>
                                        <div class="text-xs text-gray-500">{{ $data['nama_customer'] }}</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="font-medium text-gray-700">{{ $data['barang'] }}</div>
                                    </td>
                                    <td class="py-3 px-4 text-center font-bold text-gray-800">
                                        {{ $data['qty'] }}
                                    </td>
                                    <td class="py-3 px-4 text-gray-500 italic">
                                        {{ number_format($data['harga_beli'], 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 text-blue-600 font-medium">
                                        {{ number_format($data['harga_jual'], 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 text-gray-500">
                                        {{ number_format($data['modal_total'], 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 text-gray-800 font-medium">
                                        {{ number_format($data['pendapatan_total'], 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold {{ $data['keuntungan_total'] >= 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                            {{ number_format($data['keuntungan_total'], 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="py-20 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                            <span class="text-gray-400 font-medium">Tidak ada data transaksi ditemukan untuk rentang waktu ini.</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            @if(count($reportData) > 0)
                            <tfoot class="bg-gray-100/50 border-t border-gray-200">
                                <tr class="font-bold text-gray-800">
                                    <td colspan="3" class="py-4 px-4 text-right">TOTAL KESELURUHAN:</td>
                                    <td class="py-4 px-4 text-center">{{ number_format($summary['total_items_sold'], 0, ',', '.') }}</td>
                                    <td colspan="2"></td>
                                    <td class="py-4 px-4">Rp {{ number_format($summary['total_modal'], 0, ',', '.') }}</td>
                                    <td class="py-4 px-4">Rp {{ number_format($summary['total_pendapatan'], 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 text-right">
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-black bg-emerald-600 text-white shadow-sm">
                                            Rp {{ number_format($summary['total_keuntungan'], 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script>
        // Sidebar logic (consistent with other pages)
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
        });
    </script>
</body>
</html>
