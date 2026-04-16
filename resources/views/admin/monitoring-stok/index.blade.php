<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Monitoring Stok | Ranay Nusantara Sejathera</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS & HTML5-QRCode CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
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
        .barcode-input:focus {
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
        }
    </style>
</head>
<body class="text-gray-800 flex h-screen overflow-x-hidden">

    @include('layouts.navbar')

    <!-- Main Content -->
    <main id="main-content" class="flex-1 md:ml-64 pt-16 flex flex-col h-screen overflow-x-hidden relative transition-all duration-300">
        <div class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8 relative w-full">
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto space-y-6 relative z-10">
                
                <!-- Page Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Monitoring Stok Gudang</h2>
                        <p class="text-gray-500 text-sm mt-1">Pantau stok terkini. Hanya untuk viewing dan barcode scanning.</p>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 md:gap-4 mb-6 md:mb-8">
                    <!-- Total Stok Unit -->
                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-full -mr-12 -mt-12 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10 flex flex-col h-full">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="p-2 rounded-xl bg-rns-blue text-white shadow-md shadow-blue-100">
                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-12 10-4-4m16 0l-8 4-8-4m16 0l-8 4-8-4"></path></svg>
                                </div>
                                <span class="text-[9px] md:text-[10px] font-medium text-gray-400 uppercase tracking-widest">Total Stok</span>
                            </div>
                            <div class="mt-auto">
                                <h3 class="text-xl md:text-2xl font-medium text-gray-900 leading-none mb-1">{{ number_format($stats['total_stok'], 0, ',', '.') }}</h3>
                                <p class="text-gray-500 text-[10px] md:text-xs">Unit Keseluruhan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Barang -->
                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-gray-100 rounded-full -mr-12 -mt-12 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10 flex flex-col h-full">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="p-2 rounded-xl bg-gray-500 text-white shadow-md shadow-gray-200">
                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                </div>
                                <span class="text-[9px] md:text-[10px] font-medium text-gray-400 uppercase tracking-widest">Varian</span>
                            </div>
                            <div class="mt-auto">
                                <h3 class="text-xl md:text-2xl font-medium text-gray-900 leading-none mb-1">{{ number_format($stats['total_barang'], 0, ',', '.') }}</h3>
                                <p class="text-gray-500 text-[10px] md:text-xs">Jenis Barang</p>
                            </div>
                        </div>
                    </div>

                    <!-- Stok Tersedia -->
                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-green-50 rounded-full -mr-12 -mt-12 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10 flex flex-col h-full">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="p-2 rounded-xl bg-green-500 text-white shadow-md shadow-green-200">
                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span class="text-[9px] md:text-[10px] font-medium text-gray-400 uppercase tracking-widest">Tersedia</span>
                            </div>
                            <div class="mt-auto">
                                <h3 class="text-xl md:text-2xl font-medium text-gray-900 leading-none mb-1">{{ number_format($stats['stok_tersedia'], 0, ',', '.') }}</h3>
                                <p class="text-gray-500 text-[10px] md:text-xs">Stok Aman (≥ 10)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Stok Menipis -->
                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-orange-50 rounded-full -mr-12 -mt-12 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10 flex flex-col h-full">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="p-2 rounded-xl bg-orange-500 text-white shadow-md shadow-orange-200">
                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="text-[9px] md:text-[10px] font-medium text-gray-400 uppercase tracking-widest">Menipis</span>
                            </div>
                            <div class="mt-auto">
                                <h3 class="text-xl md:text-2xl font-medium text-gray-900 leading-none mb-1">{{ number_format($stats['stok_menipis'], 0, ',', '.') }}</h3>
                                <p class="text-gray-500 text-[10px] md:text-xs">Stok Sedikit (< 10)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Stok Habis -->
                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md hover:-translate-y-1 transition-all duration-300 col-span-2 lg:col-span-1">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-red-50 rounded-full -mr-12 -mt-12 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10 flex flex-col h-full">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="p-2 rounded-xl bg-red-500 text-white shadow-md shadow-red-200">
                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </div>
                                <span class="text-[9px] md:text-[10px] font-medium text-gray-400 uppercase tracking-widest">Habis</span>
                            </div>
                            <div class="mt-auto">
                                <h3 class="text-xl md:text-2xl font-medium text-gray-900 leading-none mb-1">{{ number_format($stats['stok_habis'], 0, ',', '.') }}</h3>
                                <p class="text-gray-500 text-[10px] md:text-xs">Stok 0</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alert Messages -->
                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg mb-6 flex justify-between items-center shadow-sm">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg mb-6 flex justify-between items-center shadow-sm">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif

                <!-- Search Filter Form -->
                <form action="{{ route('monitoring-stok.index') }}" method="GET" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row items-center gap-4 mb-6">
                    <!-- Status Filter -->
                    <div class="w-full md:w-48">
                        <select name="status" onchange="this.form.submit()" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm transition-all text-gray-700">
                            <option value="">-- Semua Status --</option>
                            <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia (> 10)</option>
                            <option value="menipis" {{ request('status') == 'menipis' ? 'selected' : '' }}>Menipis (1 - 10)</option>
                            <option value="habis" {{ request('status') == 'habis' ? 'selected' : '' }}>Habis (0)</option>
                        </select>
                    </div>

                    <!-- Search Input -->
                    <div class="flex-1 w-full relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm" placeholder="Cari Manual: nama, SKU, atau pabrik...">
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2 w-full md:w-auto">
                        <button type="submit" class="flex-1 md:flex-none px-5 py-2 bg-rns-blue text-white rounded-lg hover:bg-blue-800 text-sm font-medium shadow-sm transition-all">
                            Cari
                        </button>
                        @if(request()->anyFilled(['search', 'status']))
                            <a href="{{ route('monitoring-stok.index') }}" class="flex-1 md:flex-none px-5 py-2 bg-white border border-gray-100 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium text-center shadow-sm transition-all">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Data Grid / Table -->
                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                    @forelse ($barangs as $barang)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow cursor-pointer" onclick="openDetailModal({{ json_encode($barang->load('barangMasuks.user')) }})">
                        @php
                            $latestImage = null;
                            if($barang->barangMasuks->count() > 0) {
                                foreach($barang->barangMasuks as $bm) {
                                    $imgs = is_string($bm->images) ? json_decode($bm->images, true) : $bm->images;
                                    // Handle double encode
                                    if (is_string($imgs)) $imgs = json_decode($imgs, true);
                                    
                                    if(is_array($imgs) && count($imgs) > 0) {
                                        $latestImage = $imgs[0];
                                        break;
                                    }
                                }
                            }
                        @endphp
                        
                        <!-- Header Image Section -->
                        <div class="w-full h-32 sm:h-48 bg-gray-100 relative overflow-hidden flex items-center justify-center border-b border-gray-100 group-hover:opacity-90 transition-opacity">
                            @if($latestImage)
                                <img src="{{ asset('storage/' . $latestImage) }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="absolute bottom-3 right-3 text-[10px] text-gray-400 font-medium bg-white/80 px-2 py-0.5 rounded backdrop-blur-sm">No Image</span>
                            @endif

                            <!-- Badges Overlay -->
                            <div class="absolute top-2 left-2 sm:top-3 sm:left-3 bg-white/90 backdrop-blur-sm shadow-sm text-rns-blue text-[8px] sm:text-xs font-bold px-1.5 py-0.5 sm:px-2.5 sm:py-1 rounded">
                                {{ $barang->sku }}
                            </div>

                            <div class="absolute top-2 right-2 sm:top-3 sm:right-3">
                                @if($barang->stock >= 10)
                                    <span class="flex items-center text-[8px] sm:text-xs font-medium text-green-700 bg-green-100/90 backdrop-blur-sm px-1.5 py-0.5 sm:px-2.5 sm:py-1 rounded shadow-sm">
                                        <span class="w-1 h-1 sm:w-1.5 sm:h-1.5 rounded-full bg-green-500 mr-1 sm:mr-1.5"></span> Tersedia
                                    </span>
                                @elseif($barang->stock > 0 && $barang->stock < 10)
                                    <span class="flex items-center text-[8px] sm:text-xs font-medium text-yellow-700 bg-yellow-100/90 backdrop-blur-sm px-1.5 py-0.5 sm:px-2.5 sm:py-1 rounded shadow-sm">
                                        <span class="w-1 h-1 sm:w-1.5 sm:h-1.5 rounded-full bg-yellow-500 mr-1 sm:mr-1.5"></span> Menipis
                                    </span>
                                @else
                                    <span class="flex items-center text-[8px] sm:text-xs font-medium text-white bg-red-500/90 backdrop-blur-sm px-1.5 py-0.5 sm:px-2.5 sm:py-1 rounded shadow-sm">
                                        <span class="w-1 h-1 sm:w-1.5 sm:h-1.5 rounded-full bg-white mr-1 sm:mr-1.5"></span> Habis
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-3 sm:p-5 flex flex-col flex-1">
                            <h3 class="text-xs sm:text-lg font-bold text-gray-800 mb-0.5 sm:mb-1 leading-tight line-clamp-2 h-8 sm:h-14">{{ $barang->name }}</h3>
                            <p class="text-[9px] sm:text-xs text-gray-500 mb-2 sm:mb-4 truncate">{{ $barang->factory ?? '-' }}</p>
                            
                            <div class="bg-gray-50 rounded-lg sm:rounded-xl p-2 sm:p-3 flex flex-col sm:flex-row justify-between items-start sm:items-center mt-auto border border-gray-100 gap-1 sm:gap-0">
                                <div>
                                    <p class="text-[8px] sm:text-[11px] text-gray-500 font-medium uppercase tracking-wider mb-0">Stok</p>
                                    <p class="font-bold text-gray-800 text-sm sm:text-xl">{{ $barang->stock }} <span class="text-[9px] sm:text-sm font-medium text-gray-500">{{ $barang->unit }}</span></p>
                                </div>
                                <div class="sm:text-right">
                                    <p class="text-[8px] sm:text-[11px] text-gray-500 font-medium uppercase tracking-wider mb-0 hidden sm:block">Harga Jual</p>
                                    <p class="font-bold text-rns-blue text-[10px] sm:text-sm">Rp {{ number_format($barang->selling_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50/50 border-t border-gray-100 px-3 py-2 sm:px-5 sm:py-3 flex justify-between items-center group-hover:bg-blue-50 transition-colors">
                            <span class="text-[9px] sm:text-xs font-medium text-gray-500">Detail</span>
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-400 group-hover:text-rns-blue transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-12 text-center bg-white rounded-xl border border-gray-100 border-dashed">
                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        <p class="text-gray-500 font-medium">Belum ada barang di Gudang.</p>
                        <p class="text-gray-400 text-sm mt-1">Stok akan muncul saat ada Barang Masuk.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($barangs->hasPages())
                <div class="p-4 bg-white rounded-xl border border-gray-100 mt-6">
                    {{ $barangs->links() }}
                </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Modal Detail Scan -->
    <div id="detailModal" class="fixed inset-0 bg-gray-900/80 hidden z-50 flex items-center justify-center p-4 sm:p-0 overflow-y-auto backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl mx-auto transform transition-all overflow-hidden my-4 sm:my-8 flex flex-col max-h-[90vh]">
            <div class="bg-rns-blue p-5 sm:p-6 text-white relative flex justify-between items-start shrink-0">
                <div>
                    <span id="detailSku" class="inline-block px-2.5 py-1 sm:px-3 sm:py-1 bg-white/20 rounded-full text-[10px] sm:text-xs font-semibold tracking-wider mb-2"></span>
                    <h3 id="detailName" class="text-xl sm:text-2xl font-bold leading-tight line-clamp-2"></h3>
                </div>
                <button onclick="closeModal('detailModal')" class="text-white/70 hover:text-white bg-white/10 hover:bg-white/20 p-1.5 sm:p-2 rounded-full transition-colors shrink-0 ml-3">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-4 sm:p-6 overflow-y-auto overflow-x-hidden">
                <!-- Multiple Images Gallery Container -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-[11px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider">Galeri Foto Barang</p>
                        <span id="detailImageCount" class="text-[10px] sm:text-xs font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-100">0 Foto</span>
                    </div>
                    <div id="detailImagesContainer" class="flex gap-3 overflow-x-auto pb-4 snap-x snap-mandatory hide-scroll">
                        <!-- Populated by JS -->
                    </div>
                </div>

                <style>
                    /* Hide scrollbar for images container but keep functionality */
                    .hide-scroll::-webkit-scrollbar {
                        height: 6px;
                    }
                    .hide-scroll::-webkit-scrollbar-track {
                        background: #f1f5f9; 
                        border-radius: 4px;
                    }
                    .hide-scroll::-webkit-scrollbar-thumb {
                        background: #cbd5e1; 
                        border-radius: 4px;
                    }
                    .hide-scroll::-webkit-scrollbar-thumb:hover {
                        background: #94a3b8; 
                    }
                </style>

                <!-- Stok Card -->
                <div class="flex flex-col items-center justify-center p-4 sm:p-6 bg-blue-50/50 rounded-2xl border border-blue-100 mb-6 text-center">
                    <p class="text-xs sm:text-sm font-semibold text-blue-800 uppercase tracking-wider mb-1 sm:mb-2">Stok Saat Ini</p>
                    <div class="flex items-baseline justify-center gap-1.5 sm:gap-2">
                        <span id="detailStock" class="text-5xl sm:text-6xl font-black text-rns-blue tracking-tight"></span>
                        <span id="detailUnit" class="text-lg sm:text-xl font-bold text-blue-600 truncate max-w-[150px]"></span>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-6">
                    <div class="bg-gray-50 p-3 sm:p-0 sm:bg-transparent rounded-lg">
                        <p class="text-[11px] sm:text-xs text-gray-500 mb-0.5 sm:mb-1 block">Pabrik Asal</p>
                        <p id="detailFactory" class="font-medium text-gray-800 text-sm sm:text-base break-words"></p>
                    </div>
                    <div class="bg-gray-50 p-3 sm:p-0 sm:bg-transparent rounded-lg">
                        <p class="text-[11px] sm:text-xs text-gray-500 mb-0.5 sm:mb-1 block">Merek</p>
                        <p id="detailMerek" class="font-medium text-gray-800 text-sm sm:text-base break-words"></p>
                    </div>
                    <div class="bg-gray-50 p-3 sm:p-0 sm:bg-transparent rounded-lg">
                        <p class="text-[11px] sm:text-xs text-gray-500 mb-0.5 sm:mb-1 block">Berat (Kg)</p>
                        <p id="detailBerat" class="font-medium text-gray-800 text-sm sm:text-base break-words"></p>
                    </div>
                    <div class="bg-gray-50 p-3 sm:p-0 sm:bg-transparent rounded-lg">
                        <p class="text-[11px] sm:text-xs text-gray-500 mb-0.5 sm:mb-1 block">Tanggal Terdaftar</p>
                        <p id="detailDate" class="font-medium text-gray-800 text-sm sm:text-base break-words"></p>
                    </div>
                    <div class="bg-gray-50 p-3 sm:p-0 sm:bg-transparent rounded-lg">
                        <p class="text-[11px] sm:text-xs text-gray-500 mb-0.5 sm:mb-1 block">Diinput Oleh</p>
                        <p id="detailUser" class="font-medium text-gray-800 text-sm sm:text-base break-words"></p>
                    </div>
                    <div class="col-span-1 sm:col-span-2 sm:pt-4 sm:border-t border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 bg-blue-50/50 sm:bg-transparent p-3 sm:p-0 rounded-lg">
                        <div>
                            <p class="text-[11px] sm:text-xs text-gray-500 mb-0.5 sm:mb-1 block">Harga Modal</p>
                            <p id="detailPurchase" class="font-bold text-gray-700 text-sm sm:text-base"></p>
                        </div>
                        <div class="sm:text-right w-full sm:w-auto pt-2 border-t border-blue-100 sm:border-none sm:pt-0">
                            <p class="text-[11px] sm:text-xs text-gray-500 mb-0.5 sm:mb-1 block">Harga Jual</p>
                            <p id="detailSelling" class="font-bold text-rns-blue text-lg sm:text-xl"></p>
                        </div>
                    </div>
                </div>

                <!-- Stock History Section -->
                <div class="mt-8 pt-6 border-t border-gray-100">
                    <p class="text-[11px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">Riwayat Penambahan Stok</p>
                    <div class="bg-white border border-gray-100 rounded-xl overflow-hidden overflow-x-auto">
                        <table class="w-full text-left text-[11px] sm:text-xs">
                            <thead class="bg-gray-50 border-b border-gray-100 text-gray-500">
                                <tr>
                                    <th class="py-2 px-3 font-semibold">Tanggal</th>
                                    <th class="py-2 px-3 font-semibold">Qty</th>
                                    <th class="py-2 px-3 font-semibold">Oleh</th>
                                </tr>
                            </thead>
                            <tbody id="detailHistoryBody" class="divide-y divide-gray-50">
                                <!-- Populated by JS -->
                            </tbody>
                        </table>
                    </div>
                    <div id="detailHistoryMore" class="mt-3 text-center hidden">
                        <p class="text-[10px] text-gray-400 font-medium italic">Menampilkan 5 riwayat terbaru. Lihat selengkapnya di menu Barang Masuk.</p>
                    </div>
                </div>

                <!-- Generated Barcode Display -->
                <div class="mt-6 sm:mt-8 pt-5 sm:pt-6 border-t border-gray-100 text-center">
                    <p class="text-[10px] sm:text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 sm:mb-3">Barcode Sistem</p>
                    <div class="inline-block p-3 sm:p-4 bg-white border border-gray-200 rounded-xl shadow-sm w-full sm:w-auto">
                        <img id="detailBarcodeSVG" src="" class="h-12 sm:h-16 w-auto mx-auto mb-2 opacity-90 max-w-full" alt="Barcode">
                        <p id="detailBarcodeText" class="text-[10px] sm:text-xs font-mono text-gray-600 tracking-[0.1em] sm:tracking-[0.2em] break-all"></p>
                    </div>
                </div>
            </div>
            
            <div class="px-4 py-3 sm:px-6 sm:py-4 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row justify-between shrink-0 gap-3">
                <div class="w-full sm:w-auto">
                    @if(auth()->user()->role === 'owner')
                    <button type="button" onclick="openModal('passwordModal')" class="w-full sm:w-auto px-5 py-2.5 sm:py-2.5 bg-red-50 text-red-600 border border-red-200 rounded-lg hover:bg-red-100 font-medium text-sm transition-colors text-center flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Hapus Permanen
                    </button>
                    @endif
                </div>
                <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                    <button id="detailPrintBarcodeBtn" type="button" class="w-full sm:w-auto px-5 py-2.5 sm:py-2.5 bg-blue-50 text-rns-blue border border-blue-200 rounded-lg hover:bg-blue-100 font-medium text-sm transition-colors text-center flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Print Barcode
                    </button>
                    <button type="button" onclick="closeModal('detailModal')" class="w-full sm:w-auto px-5 py-2.5 sm:py-2.5 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 font-medium text-sm transition-colors text-center">Tutup Detail</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Confirmation Modal for Delete -->
    <div id="passwordModal" class="fixed inset-0 bg-gray-900/80 hidden z-[60] flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm mx-auto transform transition-all overflow-hidden relative flex flex-col">
            <div class="p-6">
                <h3 class="text-lg font-bold text-red-600 mb-2">Konfirmasi Hapus Permanen</h3>
                <p class="text-[13px] text-gray-600 mb-4">Semua riwayat stok barang yang berhubungan dengan produk ini akan ikut terhapus. Masukkan password akun Anda untuk melanjutkan keamanan.</p>
                
                <form id="deleteBarangForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Autentikasi</label>
                        <input type="password" name="password" required class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-red-500 focus:border-red-500" placeholder="••••••••">
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2 mt-5">
                        <button type="button" onclick="closeModal('passwordModal')" class="w-full sm:w-1/2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium transition-colors">Batal</button>
                        <button type="submit" class="w-full sm:w-1/2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium transition-colors">Yakin, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Print Quantity Modal -->
    <div id="printQtyModal" class="fixed inset-0 bg-gray-900/80 hidden z-[60] flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm mx-auto transform transition-all overflow-hidden relative flex flex-col">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-rns-blue shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Cetak Barcode</h3>
                        <p id="printModalSku" class="text-xs font-mono text-gray-500 mt-0.5 tracking-wider"></p>
                    </div>
                </div>
                
                <p class="text-[13px] text-gray-600 mb-4">Tentukan berapa banyak salinan barcode yang ingin Anda cetak diletakkan mendatar di kertas.</p>
                
                <form id="printQtyForm" onsubmit="submitPrintQty(event)">
                    <input type="hidden" id="printModalBarangId">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Cetak <span class="text-xs text-gray-400 font-normal">(Maks: 500)</span></label>
                        <input type="number" id="printModalQty" min="1" max="500" value="1" required class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue">
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2 mt-5">
                        <button type="button" onclick="closeModal('printQtyModal')" class="w-full sm:w-1/2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium transition-colors">Batal</button>
                        <button type="submit" class="w-full sm:w-1/2 px-4 py-2 bg-rns-blue text-white rounded-lg hover:bg-blue-800 text-sm font-medium transition-colors flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Cetak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Scanner -->
    <div id="scannerModal" class="fixed inset-0 bg-gray-900/80 hidden z-50 flex items-center justify-center p-4 sm:p-0 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm mx-auto transform transition-all overflow-hidden relative flex flex-col max-h-[90vh]">
            <button onclick="closeScannerModal()" class="absolute top-3 right-3 sm:top-4 sm:right-4 text-gray-500 hover:text-gray-800 z-50 transition-colors bg-white/80 backdrop-blur-sm shadow-sm rounded-full p-1.5 border border-gray-100">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="p-5 sm:p-6 text-center pt-8 sm:pt-10 overflow-y-auto">
                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-blue-50/50 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4 text-rns-blue shadow-inner">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-1 sm:mb-2">Kamera Pemindai</h3>
                <p class="text-[11px] sm:text-xs text-gray-500 mb-3 sm:mb-4 px-2">Pilih kamera, lalu klik <span class="font-bold text-gray-700">Mulai Scan</span></p>

                <!-- Custom Camera Controls -->
                <div class="mb-3 sm:mb-4 w-full flex flex-col gap-2">
                    <select id="camera-select" class="block w-full py-2 px-3 border border-gray-200 bg-gray-50 rounded-lg text-sm outline-none focus:ring-2 focus:ring-rns-blue text-gray-700 font-medium">
                        <option value="">Memuat Kamera...</option>
                    </select>
                    <div class="flex gap-2 w-full">
                        <button id="start-btn" onclick="startScanner()" class="flex-1 bg-rns-blue text-white py-2 rounded-lg font-medium text-sm hover:bg-blue-800 transition-colors shadow-sm">
                            Mulai Scan
                        </button>
                        <button id="stop-btn" onclick="stopScanner()" class="flex-1 bg-red-50 text-red-600 border border-red-200 py-2 rounded-lg font-medium text-sm hover:bg-red-100 transition-colors hidden">
                            Berhenti
                        </button>
                    </div>
                </div>
                
                <!-- Target div for html5-qrcode -->
                <div id="reader-container" class="w-full aspect-square sm:aspect-video bg-black rounded-xl overflow-hidden shadow-inner relative flex flex-col justify-center border border-gray-200">
                    <div id="reader" class="w-full h-full"></div>
                </div>
                
                <!-- Optional Manual Text Input fallback -->
                <div class="mt-4 sm:mt-5 pt-4 text-left">
                    <p class="text-[10px] sm:text-xs text-gray-400 mb-2 uppercase tracking-wide font-semibold pl-1 text-center">Atau Input Cepat</p>
                    <form id="scanForm" onsubmit="manualSubmitScan(event)">
                        <input type="text" id="barcodeInput" class="barcode-input block w-full px-4 py-2.5 sm:py-3 border border-gray-300 focus:ring-2 focus:ring-blue-100 focus:border-rns-blue rounded-xl outline-none text-center font-mono text-sm sm:text-base mb-1 shadow-sm transition-all" placeholder="Ketik manual kode SKU..." autocomplete="off">
                    </form>
                </div>
            </div>
            <div class="bg-gray-50 border-t border-gray-100 p-3 sm:p-4 text-center shrink-0">
                <button type="button" onclick="closeScannerModal()" class="w-full px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 text-sm transition-colors">Tutup Kamera</button>
            </div>
        </div>
    </div>

    <!-- Floating Action Button Scanner -->
    <button onclick="openScannerModal()" class="fixed bottom-6 right-6 sm:bottom-8 sm:right-8 z-40 bg-rns-blue text-white rounded-full px-4 py-3 sm:px-6 sm:py-4 shadow-[0_8px_30px_rgb(30,58,138,0.3)] hover:bg-blue-800 hover:shadow-[0_8px_30px_rgb(30,58,138,0.5)] transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2 tracking-wide font-bold xl:text-lg">
        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
        <span class="text-sm sm:text-base">SCAN</span>
    </button>

    <!-- Scripts -->
    <script>
        // Camera Scanner variables
        let html5QrCode = null;
        let selectedCameraId = null;

        // Modal Logic
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.body.style.overflow = '';
        }

        function populateCameras() {
            Html5Qrcode.getCameras().then(devices => {
                const select = document.getElementById('camera-select');
                select.innerHTML = ''; // clear loading

                if (devices && devices.length) {
                    devices.forEach(device => {
                        const option = document.createElement('option');
                        option.value = device.id;
                        // Better formatting for back cameras
                        option.text = device.label || `Kamera ${select.length + 1}`;
                        select.appendChild(option);
                    });
                    
                    // Try to auto-select back camera if found in name
                    let backCamId = devices.find(device => /back|rear|belakang/i.test(device.label))?.id;
                    if(backCamId) {
                        select.value = backCamId;
                    }

                    selectedCameraId = select.value;

                    // AUTO START SCANNER
                    setTimeout(() => {
                        startScanner();
                    }, 300);

                } else {
                    select.innerHTML = '<option value="">Tidak Ditemukan Kamera</option>';
                    document.getElementById('start-btn').disabled = true;
                    document.getElementById('start-btn').classList.add('opacity-50', 'cursor-not-allowed');
                }
            }).catch(err => {
                // handle error
                console.error("Camera loading err:", err);
                const select = document.getElementById('camera-select');
                select.innerHTML = '<option value="">Izin Kamera Ditolak</option>';
                document.getElementById('start-btn').disabled = true;
                document.getElementById('start-btn').classList.add('opacity-50', 'cursor-not-allowed');
            });
        }

        // Event Listener if user changes camera
        document.getElementById('camera-select').addEventListener('change', (e) => {
            selectedCameraId = e.target.value;
            // if scanner is running, restart it with new camera
            if(html5QrCode && html5QrCode.isScanning) {
                stopScanner().then(() => startScanner());
            }
        });

        function startScanner() {
            if (!selectedCameraId) return;
            
            if (!html5QrCode) {
                html5QrCode = new Html5Qrcode("reader");
            }

            document.getElementById('start-btn').classList.add('hidden');
            document.getElementById('stop-btn').classList.remove('hidden');
            document.getElementById('camera-select').disabled = true;
            document.getElementById('reader-container').classList.remove('border-gray-200');
            document.getElementById('reader-container').classList.add('border-rns-blue', 'ring-4', 'ring-blue-100');

            html5QrCode.start(
                selectedCameraId,
                {
                    fps: 10,
                    qrbox: { width: 250, height: 150 },
                    aspectRatio: 1.0
                },
                onScanSuccess,
                onScanFailure
            ).catch(err => {
                console.error("Failed to start scan:", err);
                resetUIScanner();
                alert("Gagal memulai kamera. Pastikan browser tidak memblokirnya.");
            });
        }

        function stopScanner() {
            return new Promise((resolve) => {
                if(html5QrCode && html5QrCode.isScanning) {
                    html5QrCode.stop().then(() => {
                        resetUIScanner();
                        resolve();
                    }).catch(err => {
                        console.error("Failed to stop scan:", err);
                        resolve();
                    });
                } else {
                    resolve();
                }
            });
        }

        function resetUIScanner() {
            document.getElementById('start-btn').classList.remove('hidden');
            document.getElementById('stop-btn').classList.add('hidden');
            document.getElementById('camera-select').disabled = false;
            document.getElementById('reader-container').classList.add('border-gray-200');
            document.getElementById('reader-container').classList.remove('border-rns-blue', 'ring-4', 'ring-blue-100');
        }

        function openScannerModal() {
            openModal('scannerModal');
            
            // Check if browser supports camera
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                alert("Kamera tidak dapat diakses! Pastikan Anda mengakses web ini menggunakan HTTPS atau localhost.");
                return;
            }

            // Populate camera list on open
            populateCameras();
        }

        function closeScannerModal() {
            closeModal('scannerModal');
            stopScanner();
            let input = document.getElementById('barcodeInput');
            input.value = '';
            input.disabled = false;
        }

        function onScanSuccess(decodedText, decodedResult) {
            // Check if we are already processing to prevent spamming the backend
            if(document.getElementById('barcodeInput').disabled) return;
            
            // Play a beep sound optionally (omitted for simplicity, but we can visually change UI)
            console.log(`Code matched = ${decodedText}`, decodedResult);
            processSkuScan(decodedText);
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning
            // console.warn(`Code scan error = ${error}`);
        }

        function manualSubmitScan(e) {
            e.preventDefault();
            const sku = document.getElementById('barcodeInput').value.trim();
            if(sku) {
                processSkuScan(sku);
            }
        }

        // Format Currency
        const formatRupiah = (number) => {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
        };

        // Open Detail
        function openDetailModal(barang) {
            document.getElementById('detailSku').innerText = barang.sku;
            document.getElementById('detailName').innerText = barang.name;
            document.getElementById('detailFactory').innerText = barang.factory || '-';
            document.getElementById('detailMerek').innerText = barang.merek || '-';
            document.getElementById('detailBerat').innerText = barang.berat_barang ? `${barang.berat_barang} Kg` : '-';
            
            document.getElementById('detailUser').innerText = barang.user ? barang.user.name : 'Sistem / Tidak Diketahui';
            
            let dt = new Date(barang.created_at);
            document.getElementById('detailDate').innerText = dt.toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'});
            
            document.getElementById('detailStock').innerText = barang.stock;
            document.getElementById('detailUnit').innerText = barang.unit;
            
            document.getElementById('detailPurchase').innerText = formatRupiah(barang.purchase_price);
            document.getElementById('detailSelling').innerText = formatRupiah(barang.selling_price);

            // Set Print Barcode Link
            document.getElementById('detailPrintBarcodeBtn').href = `/admin/monitoring-stok/${barang.id}/print-barcode`;

            // Fetch All Images (from barang_masuk records)
            const imagesContainer = document.getElementById('detailImagesContainer');
            const imageCountBadge = document.getElementById('detailImageCount');
            imagesContainer.innerHTML = '';
            
            let allImages = [];
            
            // Note: The relation property can be barang_masuks (from raw backend property injection) 
            // or barangMasuks (from the controller 'with' clause when scanned). Check both.
            const bMasuks = barang.barang_masuks || barang.barangMasuks;

            if (bMasuks && bMasuks.length > 0) {
                // Collect images from all records (oldest to newest or vice versa depending on how frontend sees it)
                for (let i = 0; i < bMasuks.length; i++) {
                    const bm = bMasuks[i];
                    let imagesArray = bm.images;
                    
                    if (typeof imagesArray === 'string') {
                        try {
                            imagesArray = JSON.parse(imagesArray);
                            if (typeof imagesArray === 'string') {
                                imagesArray = JSON.parse(imagesArray);
                            }
                        } catch (e) {
                            console.error('Failed to parse BM Images', e);
                            imagesArray = [];
                        }
                    }

                    if (Array.isArray(imagesArray) && imagesArray.length > 0) {
                        allImages = allImages.concat(imagesArray);
                    }
                }
            }
            
            if (allImages.length > 0) {
                // Remove duplicates
                allImages = [...new Set(allImages)];
                imageCountBadge.innerText = `${allImages.length} Foto`;
                
                allImages.forEach(img => {
                    const imgWrapper = document.createElement('div');
                    imgWrapper.className = 'w-32 h-32 sm:w-48 sm:h-48 shrink-0 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden relative snap-start group cursor-pointer';
                    
                    const imgEl = document.createElement('img');
                    imgEl.src = `/storage/${img}`;
                    imgEl.className = 'absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300';
                    imgEl.alt = 'Foto Barang';
                    imgWrapper.onclick = () => window.open(`/storage/${img}`, '_blank');
                    
                    // Add zoom icon overlay on hover
                    const overlay = document.createElement('div');
                    overlay.className = 'absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center pointer-events-none';
                    overlay.innerHTML = '<svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>';
                    
                    imgWrapper.appendChild(imgEl);
                    imgWrapper.appendChild(overlay);
                    imagesContainer.appendChild(imgWrapper);
                });
            } else {
                imageCountBadge.innerText = `0 Foto`;
                const noImgWrapper = document.createElement('div');
                noImgWrapper.className = 'w-full py-8 shrink-0 bg-gray-50 rounded-xl border border-gray-200 border-dashed flex flex-col items-center justify-center text-gray-400';
                noImgWrapper.innerHTML = '<svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg><span class="text-xs font-medium">Belum ada foto</span>';
                imagesContainer.appendChild(noImgWrapper);
            }
            
            // Populate Stock History
            const historyBody = document.getElementById('detailHistoryBody');
            const historyMore = document.getElementById('detailHistoryMore');
            historyBody.innerHTML = '';
            
            if (bMasuks && bMasuks.length > 0) {
                // Sort manual by date latest
                const sortedHistory = [...bMasuks].sort((a, b) => new Date(b.incoming_date) - new Date(a.incoming_date));
                
                // Limit to 5 items
                const limitedHistory = sortedHistory.slice(0, 5);
                
                limitedHistory.forEach(bm => {
                    const tr = document.createElement('tr');
                    tr.className = 'hover:bg-gray-50/50 transition-colors';
                    
                    const updateInfo = bm.updated_at && bm.updated_at !== bm.created_at ? 
                        `<div class="text-[9px] text-amber-600 mt-0.5">Edit: ${new Date(bm.updated_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'short'})}</div>` : '';

                    tr.innerHTML = `
                        <td class="py-3 px-3">
                            <div class="font-medium text-gray-800">${new Date(bm.incoming_date).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'})}</div>
                            ${updateInfo}
                        </td>
                        <td class="py-3 px-3">
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-green-50 text-green-700 border border-green-100">+${bm.quantity}</span>
                        </td>
                        <td class="py-3 px-3 text-gray-600 font-medium">
                            ${bm.user ? bm.user.name : '-'}
                        </td>
                    `;
                    historyBody.appendChild(tr);
                });

                // Show/hide "more" message
                if (bMasuks.length > 5) {
                    historyMore.classList.remove('hidden');
                } else {
                    historyMore.classList.add('hidden');
                }
            } else {
                historyBody.innerHTML = '<tr><td colspan="3" class="py-4 text-center text-gray-400 italic">Belum ada riwayat stok</td></tr>';
                historyMore.classList.add('hidden');
            }

            // Fetch and display barcode SVG
            if(barang.barcode_path) {
                document.getElementById('detailBarcodeSVG').src = `/storage/${barang.barcode_path}`;
                document.getElementById('detailBarcodeText').innerText = barang.sku;
                document.getElementById('detailBarcodeSVG').parentElement.classList.remove('hidden');
                
                // Print Barcode with Qty Prompt via Modal
                document.getElementById('detailPrintBarcodeBtn').onclick = function() {
                    document.getElementById('printModalSku').innerText = 'SKU: ' + barang.sku;
                    document.getElementById('printModalBarangId').value = barang.id;
                    document.getElementById('printModalQty').value = 1; // reset default
                    openModal('printQtyModal');
                };
            } else {
                document.getElementById('detailBarcodeSVG').parentElement.classList.add('hidden');
            }

            // Setup Delete Form Action
            const deleteForm = document.getElementById('deleteBarangForm');
            deleteForm.action = `/admin/monitoring-stok/${barang.id}`;

            openModal('detailModal');
        }

        // Handle Backend Request Scanning
        async function processSkuScan(sku) {
            const input = document.getElementById('barcodeInput');
            
            // Loading state
            input.disabled = true;
            input.value = "Mencari " + sku + "...";

            try {
                const response = await fetch('{{ route('monitoring-stok.scan') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ sku: sku })
                });

                const result = await response.json();

                if(response.ok && result.success) {
                    // Tutup modal scanner & Kamera, Tampilkan Modal Detail
                    closeScannerModal();
                    setTimeout(() => {
                        openDetailModal(result.data);
                    }, 100);
                } else {
                    alert(result.message || 'Barang tidak ditemukan.');
                    input.disabled = false;
                    input.value = "";
                }
            } catch (error) {
                console.error('Error fetching scan data:', error);
                alert('Terjadi kesalahan sistem saat memuat data Barcode.');
                input.disabled = false;
                input.value = "";
            }
        }

        // Handle Cusstom Print Quantity Modal Submission
        function submitPrintQty(e) {
            e.preventDefault();
            const barangId = document.getElementById('printModalBarangId').value;
            let qty = parseInt(document.getElementById('printModalQty').value);
            
            if (isNaN(qty) || qty < 1) qty = 1;
            if (qty > 500) qty = 500;
            
            closeModal('printQtyModal');
            window.open(`/admin/monitoring-stok/${barangId}/print-barcode?qty=${qty}`, '_blank');
        }
    </script>
</body>
</html>
