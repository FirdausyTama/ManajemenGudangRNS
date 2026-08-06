<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Rekanan | Rand Nusantara Sejahtera</title>
    
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

    <main id="main-content" class="flex-1 md:ml-64 pt-16 flex flex-col h-screen overflow-x-hidden relative transition-all duration-300">
        <div class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8 relative w-full">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto space-y-6 relative z-10">
                
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Manajemen Rekanan</h2>
                        <p class="text-gray-500 text-sm mt-1">Data master Customer, Supplier, dan Vendor beserta dokumennya.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('rekanan.exportExcel') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium shadow-sm transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                            Export Excel
                        </a>
                        <a href="{{ route('rekanan.exportPdf') }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium shadow-sm transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            Export PDF
                        </a>
                        <a href="{{ route('rekanan.create') }}" class="px-4 py-2 bg-rns-blue text-white rounded-lg hover:bg-blue-800 text-sm font-medium shadow-sm transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Tambah Rekanan
                        </a>
                    </div>
                </div>

                @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm">
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
                @endif
                @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm">
                    <p class="text-red-700 font-medium">{{ session('error') }}</p>
                </div>
                @endif

                <form action="{{ route('rekanan.index') }}" method="GET" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:flex-wrap items-center gap-4 mb-6 relative z-20">
                    <div class="w-full md:w-auto">
                        <select name="jenis" onchange="this.form.submit()" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm text-gray-700 transition-all">
                            <option value="">-- Semua Jenis --</option>
                            <option value="Customer" {{ request('jenis') == 'Customer' ? 'selected' : '' }}>Customer</option>
                            <option value="Supplier" {{ request('jenis') == 'Supplier' ? 'selected' : '' }}>Supplier</option>
                            <option value="Vendor" {{ request('jenis') == 'Vendor' ? 'selected' : '' }}>Vendor</option>
                        </select>
                    </div>

                    <div class="w-full md:w-auto">
                        <select name="status" onchange="this.form.submit()" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm text-gray-700 transition-all">
                            <option value="">-- Semua Status --</option>
                            <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="flex-1 w-full relative min-w-[200px]">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm" placeholder="Cari Kode, Nama Perusahaan, atau PIC...">
                    </div>
                    
                    <div class="flex gap-2 w-full md:w-auto">
                        <button type="submit" class="flex-1 md:flex-none px-5 py-2 bg-rns-blue text-white rounded-lg hover:bg-blue-800 text-sm font-medium shadow-sm transition-all">
                            Cari
                        </button>
                        @if(request()->anyFilled(['search', 'jenis', 'status']))
                            <a href="{{ url()->current() }}" class="flex-1 md:flex-none px-5 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium text-center shadow-sm transition-all">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden relative z-20">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100 text-sm text-gray-500">
                                    <th class="py-3 px-4 font-medium">Kode</th>
                                    <th class="py-3 px-4 font-medium">Nama Perusahaan</th>
                                    <th class="py-3 px-4 font-medium">Jenis</th>
                                    <th class="py-3 px-4 font-medium">PIC & Kontak</th>
                                    <th class="py-3 px-4 font-medium text-center">Jml Dok.</th>
                                    <th class="py-3 px-4 font-medium">Status</th>
                                    <th class="py-3 px-4 font-medium text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($rekanans as $item)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3 px-4">
                                        <span class="text-sm font-semibold text-gray-900">{{ $item->kode_rekanan }}</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="text-sm font-bold text-gray-800">{{ $item->nama_perusahaan }}</div>
                                        <div class="text-xs text-gray-500 truncate max-w-xs">{{ $item->kota ? $item->kota . ', ' . $item->provinsi : '-' }}</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                            {{ $item->jenis_rekanan == 'Customer' ? 'bg-blue-100 text-blue-800' : ($item->jenis_rekanan == 'Supplier' ? 'bg-purple-100 text-purple-800' : 'bg-orange-100 text-orange-800') }}">
                                            {{ $item->jenis_rekanan }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="text-sm text-gray-800 font-medium">{{ $item->nama_pic ?: '-' }}</div>
                                        <div class="text-xs text-gray-500">{{ $item->no_hp ?: '-' }}</div>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 text-gray-600 text-xs font-bold">
                                            {{ $item->dokumen_rekanans_count }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('rekanan.show', $item->id) }}" class="p-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors" title="Detail & Dokumen">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <a href="{{ route('rekanan.edit', $item->id) }}" class="p-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('rekanan.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus rekanan ini? (Dokumen juga akan disembunyikan)')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-colors" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            <p class="text-sm font-medium">Belum ada data Rekanan</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($rekanans->hasPages())
                    <div class="p-4 border-t border-gray-100">
                        {{ $rekanans->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const toggleBtn = document.getElementById('sidebar-toggle-btn');
            const mainContent = document.getElementById('main-content');

            function toggleSidebar() {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }

            if(toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
            if(overlay) overlay.addEventListener('click', toggleSidebar);
        });
    </script>
</body>
</html>
