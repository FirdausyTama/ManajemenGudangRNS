<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | Rand Nusantara Sejahtera</title>

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
        <div class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-6 lg:p-10 relative w-full bg-[#f8fbff]">
            <div class="max-w-[1600px] mx-auto space-y-6 md:space-y-10 relative z-10">
                
                <!-- Hero Banner -->
                <div class="bg-gradient-to-r from-rns-blue to-rns-light rounded-3xl p-6 md:p-8 text-white shadow-xl shadow-blue-200 relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6 mb-2">
                    <div class="absolute right-0 top-0 p-8 transform rotate-12 opacity-10 pointer-events-none">
                        <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4M12,6A6,6 0 0,0 6,12A6,6 0 0,0 12,18A6,6 0 0,0 18,12A6,6 0 0,0 12,6M12,8A4,4 0 0,1 16,12A4,4 0 0,1 12,16A4,4 0 0,1 8,12A4,4 0 0,1 12,8Z"/></svg>
                    </div>
                    
                    <div class="relative z-10">
                        <!-- <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-lg text-[10px] font-medium uppercase tracking-widest border border-white/20">WMS PRO VERSION</span>
                            <span class="flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                        </div> -->
                        <h1 class="text-2xl md:text-3xl font-medium tracking-tight mb-2">PT. Rand Nusantara Sejahtera</h1>
                        <p class="text-blue-100 text-xs md:text-sm font-normal opacity-90 leading-relaxed max-w-xl">Selamat Datang, {{ Auth::user()->name }}!</p>
                    </div>

                    <div class="relative z-10 flex flex-col md:items-end gap-4 mt-4 md:mt-0">
                        <div class="text-left md:text-right">
                            <div class="text-3xl md:text-4xl font-medium tracking-tight font-mono" id="realtime-clock">--:--:--</div>
                            <div class="text-blue-200 text-sm font-medium mt-1">{{ now()->translatedFormat('l, d F Y') }}</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('barang-masuk.index') }}" class="px-4 py-2 bg-white text-rns-blue rounded-xl font-medium hover:bg-blue-50 transition-all shadow-sm flex items-center gap-2 text-xs md:text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                Stok Baru
                            </a>
                            <a href="{{ route('penjualan.index') }}" class="px-4 py-2 bg-white/10 text-white border border-white/20 rounded-xl font-medium hover:bg-white/20 transition-all shadow-sm flex items-center gap-2 text-xs md:text-sm backdrop-blur-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                Penjualan
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Primary KPI Grid (Big Premium Cards) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
                    <!-- Total Stok -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="absolute right-0 top-0 w-32 h-32 bg-blue-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10 flex flex-col h-full">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="p-3 rounded-2xl bg-rns-blue text-white shadow-lg shadow-blue-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <span class="text-xs font-normal text-gray-400 uppercase tracking-widest">Gudang</span>
                            </div>
                            <div class="mt-auto">
                                <h3 class="text-3xl font-medium text-gray-900 leading-none mb-1">{{ number_format($totalStok, 0, ',', '.') }}</h3>
                                <p class="text-gray-500 text-xs font-normal">Total Unit Barang</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Aset -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="absolute right-0 top-0 w-32 h-32 bg-indigo-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10 flex flex-col h-full">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="p-3 rounded-2xl bg-indigo-600 text-white shadow-lg shadow-indigo-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <span class="text-xs font-normal text-gray-400 uppercase tracking-widest">Aset</span>
                            </div>
                            <div class="mt-auto">
                                <h3 class="text-2xl font-medium text-gray-900 leading-none mb-1">Rp{{ number_format($totalAssetValue, 0, ',', '.') }}</h3>
                                <p class="text-gray-500 text-xs font-normal">Nilai Investasi Stok</p>
                            </div>
                        </div>
                    </div>

                    <!-- Revenue Bulanan -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="absolute right-0 top-0 w-32 h-32 bg-emerald-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10 flex flex-col h-full">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="p-3 rounded-2xl bg-emerald-600 text-white shadow-lg shadow-emerald-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                </div>
                                <span class="text-xs font-normal text-gray-400 uppercase tracking-widest">Revenue Bln</span>
                            </div>
                            <div class="mt-auto">
                                <h3 class="text-2xl font-medium text-gray-900 leading-none mb-1">Rp{{ number_format($monthlyRevenue, 0, ',', '.') }}</h3>
                                <p class="text-gray-500 text-xs font-normal">Pendapatan {{ now()->translatedFormat('F') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Profit Bulanan -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="absolute right-0 top-0 w-32 h-32 bg-orange-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10 flex flex-col h-full">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="p-3 rounded-2xl bg-orange-500 text-white shadow-lg shadow-orange-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16V15m0 1H10m4 0h-2"></path></svg>
                                </div>
                                <span class="text-xs font-normal text-gray-400 uppercase tracking-widest">Profit Bln</span>
                            </div>
                            <div class="mt-auto">
                                <h3 class="text-2xl font-medium text-gray-900 leading-none mb-1">Rp{{ number_format($monthlyProfit, 0, ',', '.') }}</h3>
                                <p class="text-gray-500 text-xs font-normal">Keuntungan Bersih</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Peringatan Jatuh Tempo (Kelola Penjualan Style) -->
                @if($reminders->count() > 0)
                <div class="bg-white border border-orange-100 rounded-3xl shadow-sm overflow-hidden">
                    <div class="bg-orange-50 px-6 py-4 border-b border-orange-100 flex items-center gap-3">
                        <div class="p-2 bg-white rounded-lg shadow-sm">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-sm font-medium text-orange-800 uppercase tracking-wider">Perhatian: Cicilan Jatuh Tempo (7 Hari Kedepan)</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-nowrap overflow-x-auto gap-6 pb-2 scrollbar-thin scrollbar-thumb-orange-200">
                            @foreach($reminders as $rem)
                            <div class="flex-none w-64 md:w-72 p-5 bg-gray-50/50 rounded-2xl border border-gray-100 transition-hover hover:border-orange-200 hover:bg-orange-50/10">
                                <div class="flex justify-between items-start mb-3">
                                    <span class="text-[10px] font-medium text-orange-600 bg-orange-100 px-3 py-1 rounded-full uppercase">Jatuh Tempo: {{ \Carbon\Carbon::parse($rem->next_due_date)->translatedFormat('d M Y') }}</span>
                                    <a href="{{ route('penjualan.show', $rem->id) }}" class="text-[11px] font-medium text-blue-600 hover:underline uppercase">Detail</a>
                                </div>
                                <h4 class="text-sm font-medium text-gray-800 truncate mb-1">{{ $rem->nama_customer }}</h4>
                                <p class="text-[11px] font-normal text-gray-400 uppercase tracking-widest">{{ $rem->no_transaksi }} | Cicilan #{{ $rem->cicilan_paid_count + 1 }}</p>
                                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                                    <span class="text-[10px] uppercase font-medium text-gray-400">Total</span>
                                    <span class="text-sm font-medium text-gray-700">Rp{{ number_format($rem->total_keseluruhan, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    <!-- Activity Feed -->
                    <div class="lg:col-span-8 space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                            <!-- Stok Masuk Terbaru -->
                            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/30">
                                    <h4 class="font-medium text-gray-800 uppercase tracking-tight text-sm">Stok Masuk Terkini</h4>
                                    <a href="{{ route('barang-masuk.index') }}" class="text-[10px] font-medium text-rns-blue hover:underline uppercase tracking-widest leading-none">Semua</a>
                                </div>
                                <div class="divide-y divide-gray-50">
                                    @foreach($recentStockIn as $in)
                                    <div class="px-6 py-4 flex items-center gap-4 hover:bg-gray-50/30 transition-colors cursor-default">
                                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-rns-blue shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h5 class="text-xs font-medium text-gray-900 truncate uppercase">{{ $in->barang->name }}</h5>
                                            <p class="text-[10px] font-normal text-gray-400 uppercase tracking-widest">{{ $in->incoming_date->translatedFormat('d M Y') }}</p>
                                        </div>
                                        <div class="text-right shrink-0">
                                            <div class="text-sm font-medium text-gray-800">+{{ $in->quantity }}</div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Dashboard Sales Summary Table -->
                            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/30">
                                    <h4 class="font-medium text-gray-800 uppercase tracking-tight text-sm">Penjualan Terkini</h4>
                                    <a href="{{ route('penjualan.index') }}" class="text-[10px] font-medium text-rns-blue hover:underline uppercase tracking-widest leading-none">Archive</a>
                                </div>
                                <div class="divide-y divide-gray-50">
                                    @foreach($recentTransactions as $tx)
                                    <div class="px-6 py-4 flex items-center gap-4 hover:bg-gray-50/30 transition-colors cursor-default">
                                        <div class="w-10 h-10 rounded-xl {{ $tx->status_pembayaran == 'lunas' ? 'bg-emerald-50 text-emerald-600' : 'bg-orange-50 text-orange-600' }} flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h5 class="text-xs font-medium text-gray-900 truncate">{{ $tx->nama_customer }}</h5>
                                            <p class="text-[10px] font-normal text-gray-400 uppercase tracking-widest">{{ $tx->tanggal_transaksi->translatedFormat('d M Y') }}</p>
                                        </div>
                                        <div class="text-right shrink-0">
                                            <div class="text-sm font-medium text-gray-900">Rp{{ number_format($tx->total_keseluruhan / 1000, 0) }}k</div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Sidebar Widgets -->
                    <div class="lg:col-span-4 space-y-8">
                        
                        <!-- Low Stock Alert -->
                        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                            <h4 class="font-medium text-gray-800 uppercase tracking-tight text-sm mb-5">Analisis Inventaris</h4>
                            
                            <div class="space-y-6">
                                <!-- Low Stock Multiplier -->
                                <div class="bg-red-50 p-5 rounded-2xl flex items-center justify-between border border-red-100">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-white rounded-xl shadow-sm">
                                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-medium text-red-400 uppercase tracking-wider leading-none mb-1">Stok Menipis</p>
                                            <p class="text-lg font-medium text-red-600 leading-none">{{ $lowStockCount }} Item</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('monitoring-stok.index') }}" class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors shadow-lg shadow-red-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </div>

                                <!-- Transaction Split -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                        <p class="text-[9px] font-medium text-gray-400 uppercase tracking-tight mb-1">Piutang Total</p>
                                        <p class="text-xs font-medium text-gray-800 truncate">Rp{{ number_format($totalReceivable / 1000000, 1) }}jt+</p>
                                    </div>
                                    <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                        <p class="text-[9px] font-medium text-gray-400 uppercase tracking-tight mb-1">Status Cicilan</p>
                                        <p class="text-sm font-medium text-gray-800">{{ $cicilanCount }} Aktif</p>
                                    </div>
                                </div>

                                <!-- Best Seller Legend -->
                                <div class="pt-4 mt-4 border-t border-gray-100">
                                    <h5 class="text-[10px] font-medium text-gray-400 uppercase tracking-widest mb-4">Grafik Laris Terkini</h5>
                                    <div class="h-[200px] relative">
                                        <canvas id="topSellingChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Clock functionality
            function updateClock() {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                const clockElement = document.getElementById('realtime-clock');
                if(clockElement) {
                    clockElement.textContent = `${hours}:${minutes}:${seconds}`;
                }
            }
            setInterval(updateClock, 1000);
            updateClock();

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
                                    weight: 'normal'
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
