<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Penjualan | Rand Nusantara Sejahtera</title>

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
        
        /* Custom Scrollbar for Modal */
        .modal-scroll::-webkit-scrollbar { width: 6px; }
        .modal-scroll::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
        .modal-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .modal-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="text-gray-800 flex h-screen overflow-x-hidden">

    @include('layouts.navbar')

    <!-- Main Content -->
    <main id="main-content" class="flex-1 md:ml-64 pt-16 flex flex-col h-screen overflow-x-hidden relative transition-all duration-300">
        <div class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8 relative w-full">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto space-y-6 relative z-10">
                
                <!-- Page Header -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Kelola Penjualan</h2>
                        <p class="text-gray-500 text-sm mt-1">Catat transaksi penjualan barang ke pelanggan atau instansi.</p>
                    </div>
                </div>

                <!-- Alerts -->
                @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm">
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
                @endif
                @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm">
                    <ul class="list-disc list-inside text-red-700 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <!-- Summary Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6 md:mb-8">
                    <!-- Total Transaksi -->
                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-full -mr-12 -mt-12 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10 flex flex-col h-full">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="p-2 rounded-xl bg-rns-blue text-white shadow-md shadow-blue-200">
                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <span class="text-[9px] md:text-[10px] font-medium text-gray-400 uppercase tracking-widest">Semua</span>
                            </div>
                            <div class="mt-auto">
                                <h3 class="text-xl md:text-2xl font-medium text-gray-900 leading-none mb-1">{{ number_format($statusStats['lunas'] + $statusStats['cicilan'] + $statusStats['belum_lunas'], 0, ',', '.') }}</h3>
                                <p class="text-gray-500 text-[10px] md:text-xs">Total Transaksi</p>
                            </div>
                        </div>
                    </div>

                    <!-- Belum Lunas -->
                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-red-50 rounded-full -mr-12 -mt-12 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10 flex flex-col h-full">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="p-2 rounded-xl bg-red-500 text-white shadow-md shadow-red-200">
                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="text-[9px] md:text-[10px] font-medium text-gray-400 uppercase tracking-widest">Belum Lunas</span>
                            </div>
                            <div class="mt-auto">
                                <h3 class="text-xl md:text-2xl font-medium text-gray-900 leading-none mb-1">{{ number_format($statusStats['belum_lunas'], 0, ',', '.') }}</h3>
                                <p class="text-gray-500 text-[10px] md:text-xs">Invoice Belum Dibayar</p>
                            </div>
                        </div>
                    </div>

                    <!-- Cicilan -->
                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-orange-50 rounded-full -mr-12 -mt-12 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10 flex flex-col h-full">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="p-2 rounded-xl bg-orange-500 text-white shadow-md shadow-orange-200">
                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="text-[9px] md:text-[10px] font-medium text-gray-400 uppercase tracking-widest">Cicilan</span>
                            </div>
                            <div class="mt-auto">
                                <h3 class="text-xl md:text-2xl font-medium text-gray-900 leading-none mb-1">{{ number_format($statusStats['cicilan'], 0, ',', '.') }}</h3>
                                <p class="text-gray-500 text-[10px] md:text-xs">Berjalan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Lunas -->
                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-green-50 rounded-full -mr-12 -mt-12 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10 flex flex-col h-full">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="p-2 rounded-xl bg-green-500 text-white shadow-md shadow-green-200">
                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="text-[9px] md:text-[10px] font-medium text-gray-400 uppercase tracking-widest">Lunas</span>
                            </div>
                            <div class="mt-auto">
                                <h3 class="text-xl md:text-2xl font-medium text-gray-900 leading-none mb-1">{{ number_format($statusStats['lunas'], 0, ',', '.') }}</h3>
                                <p class="text-gray-500 text-[10px] md:text-xs">Transaksi Selesai</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Installment Reminders -->
                @if($reminders->count() > 0)
                <div class="bg-white border border-orange-100 rounded-xl shadow-sm overflow-hidden mb-6">
                    <div class="bg-orange-50 px-4 py-2 border-b border-orange-100 flex items-center gap-2">
                        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="text-xs font-bold text-orange-800 uppercase tracking-wider">Perhatian: Cicilan Jatuh Tempo</h3>
                    </div>
                    <div class="p-4">
                        <div class="flex flex-nowrap overflow-x-auto gap-4 pb-2 scrollbar-thin scrollbar-thumb-gray-200">
                            @foreach($reminders as $rem)
                            <div class="flex-none w-64 p-3 bg-gray-50 rounded-lg border border-gray-100">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-[10px] font-bold text-orange-600 bg-orange-100 px-2 py-0.5 rounded">Jatuh Tempo: {{ \Carbon\Carbon::parse($rem->next_due_date)->translatedFormat('d M Y') }}</span>
                                    <a href="{{ route('penjualan.show', $rem->id) }}" class="text-[10px] text-blue-600 hover:underline">Detail</a>
                                </div>
                                <h4 class="text-sm font-semibold text-gray-800 truncate">{{ $rem->nama_customer }}</h4>
                                <p class="text-[11px] text-gray-500 mt-1">{{ $rem->no_transaksi }}</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span class="text-[10px] text-gray-400">Total Tagihan</span>
                                    <span class="text-sm font-bold text-gray-700">Rp {{ number_format($rem->total_keseluruhan, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Search Form -->
                <form action="{{ route('penjualan.index') }}" method="GET" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row items-center gap-4 mb-6 relative z-20">
                    <!-- Status Filter -->
                    <div class="w-full md:w-44">
                        <select name="status" onchange="this.form.submit()" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm transition-all text-gray-700">
                            <option value="">-- Semua Status --</option>
                            <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="cicilan" {{ request('status') == 'cicilan' ? 'selected' : '' }}>Cicilan</option>
                            <option value="belum lunas" {{ request('status') == 'belum lunas' ? 'selected' : '' }}>Belum Lunas</option>
                        </select>
                    </div>

                    <!-- Period Filter -->
                    <div class="w-full md:w-44">
                        <select name="period" onchange="this.form.submit()" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm transition-all text-gray-700">
                            <option value="">-- Semua Waktu --</option>
                            <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                            <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>Tahun Ini</option>
                        </select>
                    </div>

                    <!-- Date Picker Filter -->
                    <div class="w-full md:w-40">
                        <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm transition-all text-gray-700">
                    </div>

                    <!-- Search Input -->
                    <div class="flex-1 w-full relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm" placeholder="Cari No Transaksi atau Nama Customer...">
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex gap-2 w-full md:w-auto">
                        <button type="submit" class="flex-1 md:flex-none px-5 py-2 bg-rns-blue text-white rounded-lg hover:bg-blue-800 text-sm font-medium shadow-sm transition-all">
                            Cari
                        </button>
                        @if(request()->anyFilled(['search', 'status', 'period', 'date']))
                            <a href="{{ route('penjualan.index') }}" class="flex-1 md:flex-none px-5 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium text-center shadow-sm transition-all">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Data Table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden relative z-20">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100 text-sm text-gray-500">
                                    <th class="py-3 px-4 font-medium">No Transaksi</th>
                                    <th class="py-3 px-4 font-medium">Tanggal</th>
                                    <th class="py-3 px-4 font-medium">Customer</th>
                                    <th class="py-3 px-4 font-medium">Item & Qty</th>
                                    <th class="py-3 px-4 font-medium">Total Harga</th>
                                    <th class="py-3 px-4 font-medium">Status Pembayaran</th>
                                    <th class="py-3 px-4 font-medium">Admin</th>
                                    <th class="py-3 px-4 font-medium text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y-2 divide-gray-200 text-sm">
                                @forelse ($penjualans as $p)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="py-3 px-4 font-mono text-gray-800 font-medium">
                                        {{ $p->no_transaksi }}
                                    </td>
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        {{ $p->tanggal_transaksi->format('d M Y') }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="font-medium text-gray-800">{{ $p->nama_customer }}</div>
                                        <div class="text-xs text-gray-500">{{ $p->no_hp_customer ?? '-' }}</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="text-sm font-medium text-gray-700">
                                            {{ $p->items->sum('kuantitas') }} Item
                                        </div>
                                        @if($p->is_ongkir_aktif)
                                        <div class="mt-1 text-xs text-indigo-600 font-medium bg-indigo-50 inline-block px-2 py-0.5 rounded border border-indigo-100">
                                            + Ongkir
                                        </div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 font-medium text-gray-800">
                                        Rp {{ number_format($p->total_keseluruhan, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($p->status_pembayaran === 'lunas')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 border border-green-200">Lunas</span>
                                        @elseif($p->status_pembayaran === 'cicilan')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">Cicilan</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 border border-red-200">Belum Lunas</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-xs text-gray-500">
                                        {{ $p->user->name ?? 'Sistem' }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center justify-end">
                                            <a href="{{ route('penjualan.show', $p->id) }}" class="px-3 py-1.5 bg-blue-50 text-rns-blue hover:bg-rns-blue hover:text-white rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-colors shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="py-8 text-center text-gray-500">Belum ada riwayat penjualan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t border-gray-100 flex justify-center">
                        {{ $penjualans->withQueryString()->links('vendor.pagination.custom') }}
                    </div>
                </div>

            </div>

            <!-- Floating Action Button -->
            <button onclick="openModal('addModal')" class="fixed bottom-6 right-6 z-40 bg-rns-blue text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg hover:bg-blue-800 hover:shadow-xl transition-all hover:scale-105 group" title="Tambah Penjualan Baru">
                <svg class="w-6 h-6 transform group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </button>
            
        </div>
    </main>

    <!-- Modal Tambah Data Penjualan -->
    <div id="addModal" class="fixed inset-0 bg-gray-900/60 hidden z-[60] flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-4xl max-h-[90vh] flex flex-col transform transition-all overflow-hidden relative">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-white z-10">
                <h3 class="text-lg font-bold text-gray-800">Catat Penjualan Baru</h3>
                <button type="button" onclick="closeModal('addModal')" class="text-gray-400 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-full p-1.5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 overflow-y-auto modal-scroll bg-gray-50/30 flex-1">
                <form action="{{ route('penjualan.store') }}" method="POST" id="addForm" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white p-5 rounded-lg border border-gray-100 shadow-sm">
                        <div class="md:col-span-2">
                            <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 border-b pb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-rns-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Informasi Customer
                            </h4>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Customer / Instansi <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_customer" id="namaCustomerInput" list="customerList" required class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue" placeholder="Cari atau ketik nama..." oninput="onCustomerSelect(this.value)">
                            <datalist id="customerList">
                                @foreach($pastCustomers as $customer)
                                    <option value="{{ $customer->nama_customer }}">
                                @endforeach
                            </datalist>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No HP / WhatsApp</label>
                            <input type="text" name="no_hp_customer" id="noHpInput" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue" placeholder="08123456789">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Customer</label>
                            <textarea name="alamat_customer" id="alamatInput" rows="2" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue" placeholder="Alamat lengkap pengiriman..."></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Transaksi <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_transaksi" required value="{{ date('Y-m-d') }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran Awal <span class="text-red-500">*</span></label>
                            <select name="status_pembayaran" id="statusPembayaranAdd" required onchange="toggleSignatoryAdd()" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white">
                                <option value="belum lunas" selected>Belum Lunas (Invoice Diberikan)</option>
                                <option value="cicilan">Cicilan / Termin</option>
                                <option value="lunas">Lunas</option>
                            </select>
                        </div>

                        <div id="signatoryAddField" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Penandatangan Kwitansi Lunas:</label>
                            <select name="penandatangan" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white">
                                <option value="Dewi Sulistiowati">Dewi Sulistiowati</option>
                                <option value="Heri Pirdaus, S.Tr.Kes Rad (MRI)">Heri Pirdaus</option>
                            </select>
                            <p class="text-[10px] text-indigo-600 mt-1">*Wajib diisi jika status Lunas.</p>
                        </div>

                        <script>
                            function toggleSignatoryAdd() {
                                const status = document.getElementById('statusPembayaranAdd').value;
                                const field = document.getElementById('signatoryAddField');
                                if (status === 'lunas') {
                                    field.classList.remove('hidden');
                                } else {
                                    field.classList.add('hidden');
                                }
                            }
                        </script>

                    </div>

                    <!-- Items Section -->
                    <div class="bg-white p-5 rounded-lg border border-gray-100 shadow-sm">
                        <div class="flex items-center justify-between border-b pb-2 mb-4">
                            <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-4 h-4 text-rns-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Detail Barang
                            </h4>
                            <button type="button" onclick="addItemRow()" class="text-xs font-medium bg-blue-50 text-rns-blue hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Baris
                            </button>
                        </div>

                        <div id="itemsContainer" class="space-y-4">
                            <!-- JS Will Populate First Row Here -->
                        </div>

                        <!-- Ongkir Section -->
                        <div class="mt-8 border-t border-gray-100 pt-6">
                            <label class="flex items-center cursor-pointer mb-4 w-max group">
                                <input type="checkbox" name="is_ongkir_aktif" id="isOngkirAktif" value="1" class="w-4 h-4 text-rns-blue rounded border-gray-300 focus:ring-rns-blue transition-colors" onchange="toggleOngkir()">
                                <span class="ml-2 text-sm font-bold text-gray-700 group-hover:text-rns-blue transition-colors">Gunakan Ongkos Kirim (Ongkir)</span>
                            </label>
                            
                            <div id="ongkirFields" class="hidden grid grid-cols-1 md:grid-cols-2 gap-6 bg-indigo-50/50 p-5 rounded-lg border border-indigo-100">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Berat Total (Kg) <span class="text-red-500">*</span></label>
                                    <input type="number" step="0.01" min="0" name="berat_total" id="beratTotal" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm bg-gray-100 text-gray-600 focus:ring-rns-blue focus:border-rns-blue shadow-sm cursor-not-allowed" readonly placeholder="Otomatis dihitung">
                                    <p class="text-[10px] mt-1 text-indigo-600 font-medium">*Dihitung otomatis dari berat barang di atas</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga per Kg (Rp) <span class="text-red-500">*</span></label>
                                    <input type="number" min="0" name="harga_per_kg" id="hargaPerKg" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white shadow-sm" onchange="calculateGrandTotal()" onkeyup="calculateGrandTotal()" placeholder="Contoh: 5000">
                                </div>
                                <div class="md:col-span-2 text-right pt-2 border-t border-indigo-100/60">
                                    <span class="text-xs text-gray-500 font-medium">Subtotal Ongkos Kirim:</span>
                                    <div class="font-bold text-indigo-700 text-lg" id="subtotalOngkirDisplay">Rp 0</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 border-t pt-4 flex justify-end">
                            <div class="text-right">
                                <span class="text-sm text-gray-500">Total Keseluruhan:</span>
                                <div class="text-2xl font-black text-rns-blue" id="grandTotalDisplay">Rp 0</div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 z-10 shrink-0">
                <button type="button" onclick="closeModal('addModal')" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-sm transition-colors">Batal</button>
                <button type="button" onclick="document.getElementById('addForm').submit()" class="px-5 py-2.5 bg-rns-blue text-white rounded-lg hover:bg-blue-800 font-medium text-sm transition-colors shadow-sm">Simpan Transaksi</button>
            </div>
        </div>
    </div>



    <!-- Barang Data for JS -->
    <script>
        const barangsData = @json($barangs);
        const customersData = @json($pastCustomers);
        let rowCount = 0;

        function onCustomerSelect(value) {
            const customer = customersData.find(c => c.nama_customer === value);
            if (customer) {
                document.getElementById('noHpInput').value = customer.no_hp_customer || '';
                document.getElementById('alamatInput').value = customer.alamat_customer || '';
            }
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            if (modalId === 'addModal' && rowCount === 0) {
                addItemRow(); // Auto add first row if empty
            }
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }



        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(number);
        }

        function toggleOngkir() {
            const isChecked = document.getElementById('isOngkirAktif').checked;
            const fields = document.getElementById('ongkirFields');
            const beratInput = document.getElementById('beratTotal');
            const hargaInput = document.getElementById('hargaPerKg');
            
            if (isChecked) {
                fields.classList.remove('hidden');
                beratInput.required = true;
                hargaInput.required = true;
            } else {
                fields.classList.add('hidden');
                beratInput.required = false;
                hargaInput.required = false;
                beratInput.value = '';
                hargaInput.value = '';
            }
            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let total = 0;
            let totalWeight = 0;
            const rows = document.querySelectorAll('.item-row');
            rows.forEach(row => {
                const selectElement = row.querySelector('select[name^="items["]');
                const qtyInput = row.querySelector('.item-qty');
                const priceInput = row.querySelector('.item-price');
                const subtotalDisplay = row.querySelector('.item-subtotal');
                
                const qty = parseInt(qtyInput.value) || 0;
                const price = parseInt(priceInput.value) || 0;
                const subtotal = qty * price;
                
                // Add to total weight
                if (selectElement && selectElement.selectedIndex > 0) {
                    const selectedOpt = selectElement.options[selectElement.selectedIndex];
                    const weight = parseFloat(selectedOpt.getAttribute('data-weight')) || 0;
                    totalWeight += (weight * qty);
                }
                
                subtotalDisplay.innerText = formatRupiah(subtotal);
                total += subtotal;
            });
            
            // Set Total Weight Input
            document.getElementById('beratTotal').value = totalWeight > 0 ? totalWeight : '';

            // Calculate Ongkir
            let ongkir = 0;
            if (document.getElementById('isOngkirAktif').checked) {
                const berat = totalWeight;
                const harga = parseInt(document.getElementById('hargaPerKg').value) || 0;
                ongkir = berat * harga;
                document.getElementById('subtotalOngkirDisplay').innerText = formatRupiah(ongkir);
            } else {
                document.getElementById('subtotalOngkirDisplay').innerText = formatRupiah(0);
            }

            total += ongkir;

            document.getElementById('grandTotalDisplay').innerText = formatRupiah(total);
        }

        function onBarangChange(selectTarget) {
            const row = selectTarget.closest('.item-row');
            const selectedOpt = selectTarget.options[selectTarget.selectedIndex];
            
            const priceInput = row.querySelector('.item-price');
            const stokDisplay = row.querySelector('.item-stok');
            const qtyInput = row.querySelector('.item-qty');
            
            if (selectedOpt.value) {
                const maxStock = selectedOpt.getAttribute('data-stock');
                priceInput.value = selectedOpt.getAttribute('data-price');
                stokDisplay.innerText = `Sisa Stok: ${maxStock} ${selectedOpt.getAttribute('data-unit')}`;
                
                qtyInput.max = maxStock;
                if(parseInt(qtyInput.value) > parseInt(maxStock)) {
                    qtyInput.value = maxStock;
                }
            } else {
                priceInput.value = 0;
                stokDisplay.innerText = `Sisa Stok: -`;
                qtyInput.max = "";
            }
            calculateGrandTotal();
        }

        function addItemRow() {
            const container = document.getElementById('itemsContainer');
            
            let optionsHtml = '<option value="">-- Pilih Barang --</option>';
            barangsData.forEach(b => {
                const stockText = b.stock > 0 ? `(Stok: ${b.stock})` : '(HABIS)';
                const disabled = b.stock <= 0 ? 'disabled' : '';
                optionsHtml += `<option value="${b.id}" data-price="${b.selling_price || 0}" data-stock="${b.stock}" data-unit="${b.unit || ''}" data-weight="${b.berat_barang || 0}" ${disabled}>${b.sku} - ${b.name} ${stockText}</option>`;
            });

            const rowNode = document.createElement('div');
            rowNode.className = 'item-row p-4 border border-gray-200 rounded-xl bg-gray-50/50 flex flex-col md:flex-row gap-4 items-start relative transition-all group';
            
            rowNode.innerHTML = `
                <div class="flex-1 w-full relative">
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">Pilih Produk</label>
                    <select name="items[${rowCount}][barang_id]" required class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white shadow-sm" onchange="onBarangChange(this)">
                        ${optionsHtml}
                    </select>
                    <span class="item-stok text-[11px] font-medium text-emerald-600 mt-1.5 block px-1">Sisa Stok: -</span>
                </div>
                
                <div class="w-full md:w-24">
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">Qty</label>
                    <input type="number" name="items[${rowCount}][kuantitas]" required min="1" value="1" class="item-qty w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue shadow-sm" onchange="calculateGrandTotal()" onkeyup="calculateGrandTotal()">
                </div>

                <div class="w-full md:w-36">
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">Harga Satuan</label>
                    <input type="number" name="items[${rowCount}][harga_satuan]" required min="0" value="0" class="item-price w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue shadow-sm" onchange="calculateGrandTotal()" onkeyup="calculateGrandTotal()">
                </div>

                <div class="w-full md:w-32 md:text-right">
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide md:opacity-0">Subtotal</label>
                    <div class="item-subtotal font-bold text-gray-800 py-1.5">Rp 0</div>
                </div>

                <div class="w-full md:w-auto">
                    <label class="hidden md:block text-xs mb-1.5 opacity-0">Aksi</label>
                    <button type="button" onclick="this.closest('.item-row').remove(); calculateGrandTotal();" class="absolute -top-3 -right-3 md:static md:w-auto p-2 md:px-3 md:py-2 bg-white md:bg-red-50 text-red-600 hover:bg-red-100 border border-gray-200 md:border-red-200 rounded-full md:rounded-lg shadow-sm opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center group/btn" title="Hapus Baris">
                        <svg class="w-5 h-5 md:w-4 md:h-4 md:mr-1.5 group-hover/btn:scale-110 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        <span class="hidden md:inline text-sm font-medium">Hapus</span>
                    </button>
                </div>
            `;
            
            container.appendChild(rowNode);
            rowCount++;
        }
    </script>
</body>
</html>
