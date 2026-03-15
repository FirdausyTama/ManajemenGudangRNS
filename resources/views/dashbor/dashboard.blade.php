<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | Ranay Nusantara Sejahtera</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        rns: {
                            blue: '#1e3a8a',
                            light: '#3b82f6',
                            gray: '#EEEEEE',
                            text: '#706f6c',
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
        body { font-family: 'Poppins', sans-serif; background-color: #F8FAFC; }
    </style>
</head>
<body class="text-gray-800 flex h-screen overflow-x-hidden">

    @include('layouts.navbar')

    <!-- Main Content -->
    <main id="main-content" class="flex-1 md:ml-64 pt-16 flex flex-col h-screen overflow-x-hidden relative transition-all duration-300">
        <!-- Content Area -->
        <div class="flex-1 overflow-x-hidden overflow-y-auto p-3 md:p-8 relative w-full">
            <div class="max-w-7xl mx-auto space-y-4 md:space-y-8 relative z-10">
                
                <!-- Welcome Card -->
                <div class="bg-gradient-to-r from-rns-blue to-rns-light rounded-xl p-5 md:p-8 text-white shadow-lg shadow-blue-200 flex justify-between items-center relative overflow-hidden">
                    <div class="absolute right-0 top-0 opacity-10">
                        <svg width="200" height="200" viewBox="0 0 24 24" fill="currentColor"><path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/></svg>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-lg md:text-3xl font-bold mb-1 md:mb-2">Admin Panel</h3>
                        <p class="text-blue-100 text-[10px] md:text-base opacity-90">Kelola produk & pesanan dengan mudah.</p>
                    </div>
                    <a href="/" target="_blank" class="hidden md:flex relative z-10 bg-white text-rns-blue px-6 py-2 rounded-lg font-semibold hover:bg-gray-50 transition-colors shadow items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Lihat Website
                    </a>
                </div>

                <!-- KPI Cards -->
                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-5 gap-3 md:gap-4">
                    <!-- Total Stok -->
                    <div class="bg-white p-3 md:p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-3 md:gap-4 hover:shadow-md transition-shadow">
                        <div class="p-2 md:p-3 rounded-lg md:rounded-xl bg-blue-50 text-rns-blue shadow-sm shrink-0">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div>
                            <p class="text-[9px] md:text-[10px] text-gray-400 font-black uppercase tracking-widest leading-none mb-1">Total Stok</p>
                            <p class="text-lg md:text-xl font-black text-gray-800 leading-none">{{ number_format($totalStok, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Keuntungan Bulan Ini -->
                    <div class="bg-white p-3 md:p-5 rounded-xl shadow-sm border border-emerald-100 bg-emerald-50/10 flex items-center gap-3 md:gap-4 hover:shadow-md transition-shadow">
                        <div class="p-2 md:p-3 rounded-lg md:rounded-xl bg-emerald-100 text-emerald-600 shadow-sm shrink-0">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16V15m0 1H10m4 0h-2"></path></svg>
                        </div>
                        <div>
                            <p class="text-[9px] md:text-[10px] text-gray-400 font-black uppercase tracking-widest leading-none mb-1">Profit Bln</p>
                            <p class="text-sm md:text-lg font-black text-gray-800 leading-none">Rp{{ number_format($monthlyProfit, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Total Piutang -->
                    <div class="bg-white p-3 md:p-5 rounded-xl shadow-sm border border-orange-100 bg-orange-50/10 flex items-center gap-3 md:gap-4 hover:shadow-md transition-shadow">
                        <div class="p-2 md:p-3 rounded-lg md:rounded-xl bg-orange-100 text-orange-600 shadow-sm shrink-0">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[9px] md:text-[10px] text-gray-400 font-black uppercase tracking-widest leading-none mb-1">Piutang</p>
                            <p class="text-sm md:text-lg font-black text-gray-800 leading-none">Rp{{ number_format($totalReceivable, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Total Lunas -->
                    <div class="bg-white p-3 md:p-5 rounded-xl shadow-sm border border-emerald-100 flex items-center gap-3 md:gap-4 hover:shadow-md transition-shadow">
                        <div class="p-2 md:p-3 rounded-lg md:rounded-xl bg-emerald-50 text-emerald-500 shadow-sm shrink-0">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[9px] md:text-[10px] text-gray-400 font-black uppercase tracking-widest leading-none mb-1">Trx Lunas</p>
                            <p class="text-lg md:text-xl font-black text-gray-800 leading-none">{{ $lunasCount }}</p>
                        </div>
                    </div>

                    <!-- Total Cicilan -->
                    <div class="bg-white p-3 md:p-5 rounded-xl shadow-sm border border-orange-100 flex items-center gap-3 md:gap-4 hover:shadow-md transition-shadow col-span-2 lg:col-span-1">
                        <div class="p-2 md:p-3 rounded-lg md:rounded-xl bg-orange-50 text-orange-500 shadow-sm shrink-0">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[9px] md:text-[10px] text-gray-400 font-black uppercase tracking-widest leading-none mb-1">Trx Cicilan</p>
                            <p class="text-lg md:text-xl font-black text-gray-800 leading-none">{{ $cicilanCount }}</p>
                        </div>
                    </div>
                </div>

                <!-- Peringatan Jatuh Tempo (Kelola Penjualan Style) -->
                @if($reminders->count() > 0)
                <div class="bg-white border border-orange-100 rounded-xl shadow-sm overflow-hidden md:mb-6">
                    <div class="bg-orange-50 px-4 py-2 md:py-3 border-b border-orange-100 flex items-center gap-2">
                        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="text-[10px] md:text-xs font-bold text-orange-800 uppercase tracking-wider">Perhatian: Cicilan Jatuh Tempo (7 Hari Kedepan)</h3>
                    </div>
                    <div class="p-3 md:p-4">
                        <div class="flex flex-nowrap overflow-x-auto gap-3 md:gap-4 pb-2 scrollbar-thin scrollbar-thumb-gray-200">
                            @foreach($reminders as $rem)
                            <div class="flex-none w-56 md:w-64 p-3 bg-gray-50 rounded-lg border border-gray-100">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-[9px] md:text-[10px] font-bold text-orange-600 bg-orange-100 px-2 py-0.5 rounded">Jatuh Tempo: {{ \Carbon\Carbon::parse($rem->next_due_date)->translatedFormat('d M Y') }}</span>
                                    <a href="{{ route('penjualan.show', $rem->id) }}" class="text-[10px] text-blue-600 hover:underline">Detail</a>
                                </div>
                                <h4 class="text-xs md:text-sm font-bold text-gray-800 truncate">{{ $rem->nama_customer }}</h4>
                                <p class="text-[10px] md:text-[11px] text-gray-500 mt-1">{{ $rem->no_transaksi }} | Cicilan ke-{{ $rem->cicilan_paid_count + 1 }}</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span class="text-[10px] text-gray-400">Total Tagihan</span>
                                    <span class="text-xs md:text-sm font-bold text-gray-700">Rp {{ number_format($rem->total_keseluruhan, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @else
                <div class="lg:col-span-12">
                    <div class="bg-white rounded-xl shadow-sm border border-emerald-100 overflow-hidden">
                        <div class="p-6 text-center text-gray-400">
                            <p class="text-[10px] font-bold uppercase tracking-widest leading-none text-emerald-600">Tidak ada cicilan jatuh tempo dalam 7 hari ke depan</p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 md:gap-6">
                    <!-- Left: Recent Sales -->
                    <div class="lg:col-span-7 h-full">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col h-full overflow-hidden">
                            <div class="px-3 py-2 md:px-4 md:py-3 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                                <h4 class="font-black text-gray-800 uppercase tracking-tight text-[10px] md:text-sm">5 Transaksi Terakhir</h4>
                                <a href="{{ route('penjualan.index') }}" class="text-[9px] md:text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline">Semua</a>
                            </div>
                            <div class="flex-1 overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead class="bg-gray-50/50 text-[9px] md:text-[10px] text-gray-400 font-black uppercase">
                                        <tr>
                                            <th class="px-3 py-2 md:px-4">Trx/Cust</th>
                                            <th class="px-3 py-2 md:px-4">Total</th>
                                            <th class="px-3 py-2 md:px-4 text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @foreach($recentTransactions as $tx)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="px-3 py-2 md:px-4">
                                                <div class="text-[8px] md:text-[9px] text-gray-400 font-bold leading-none mb-0.5">{{ $tx->tanggal_transaksi->format('d/m/y') }}</div>
                                                <div class="text-[10px] md:text-xs font-black text-gray-800 leading-tight truncate max-w-[80px] md:max-w-[120px]">{{ $tx->nama_customer }}</div>
                                            </td>
                                            <td class="px-3 py-2 md:px-4">
                                                <div class="text-[10px] md:text-xs font-black text-rns-blue leading-none">Rp{{ number_format($tx->total_keseluruhan, 0, ',', '.') }}</div>
                                            </td>
                                            <td class="px-3 py-2 md:px-4 text-center">
                                                <span class="px-1.5 py-0.5 rounded-full text-[7px] md:text-[8px] font-black uppercase tracking-tighter {{ $tx->status_pembayaran == 'lunas' ? 'bg-emerald-100 text-emerald-700' : 'bg-orange-100 text-orange-700' }}">
                                                    {{ $tx->status_pembayaran }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Best Selling Chart -->
                    <div class="lg:col-span-5 h-full">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 md:p-6 h-full flex flex-col">
                            <h4 class="font-black text-gray-800 uppercase tracking-tight text-[10px] md:text-sm mb-3 md:mb-4">Barang Paling Laris</h4>
                            <div class="flex-1 min-h-[180px] md:min-h-[250px] flex items-center justify-center">
                                <canvas id="topSellingChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('topSellingChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($chartData['labels']) !!},
                    datasets: [{
                        data: {!! json_encode($chartData['values']) !!},
                        backgroundColor: [
                            '#1e3a8a',
                            '#3b82f6',
                            '#10b981',
                            '#f59e0b',
                            '#ef4444'
                        ],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    family: "'Poppins', sans-serif",
                                    size: 10,
                                    weight: 'bold'
                                },
                                usePointStyle: true,
                                padding: 15
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' Terjual: ' + context.raw + ' pcs';
                                }
                            }
                        }
                    },
                    cutout: '70%'
                }
            });
        });
    </script>
</body>
</html>
