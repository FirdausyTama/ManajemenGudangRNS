<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Admin | Ranay Nusantara Sejathera</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
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
                        brand: ['Pacifico', 'cursive'],
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
        <!-- Content Area -->
        <div class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8 relative w-full">
            <!-- Background decors -->
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto space-y-6 relative z-10">
                
                <!-- Page Header -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Kelola Akses Admin</h2>
                        <p class="text-gray-500 text-sm mt-1">Persetujuan pendaftaran dan pemantauan aktivitas admin.</p>
                    </div>
                </div>

                <!-- Alerts -->
                @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-4 rounded-r shadow-sm">
                    <p class="text-green-700 font-medium whitespace-pre-wrap">{{ session('success') }}</p>
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4 rounded-r shadow-sm">
                    <p class="text-red-700 font-medium whitespace-pre-wrap">{{ session('error') }}</p>
                </div>
                @endif

                <!-- Search and Filter Form -->
                <form action="{{ route('admin.manage') }}" method="GET" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-4 items-end mb-6 relative z-10">
                    <div class="flex-1 w-full">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Admin</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-rns-blue bg-white sm:text-sm transition-colors" placeholder="Nama atau email admin...">
                        </div>
                    </div>
                    
                    <div class="w-full md:w-56">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status" class="block w-full py-2 px-3 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm bg-white transition-colors">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                        </select>
                    </div>

                    <div class="w-full md:w-auto flex flex-row gap-2">
                        <button type="submit" class="flex-1 md:flex-none px-5 py-2 bg-rns-blue text-white rounded-lg hover:bg-blue-800 transition-colors shadow-sm text-sm font-medium flex items-center justify-center gap-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            Filter
                        </button>
                        @if(request()->has('search') && request('search') != '' || request()->has('status') && request('status') != '')
                            <a href="{{ route('admin.manage') }}" class="flex-1 md:flex-none px-5 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors shadow-sm text-sm font-medium flex items-center justify-center gap-2" title="Reset Pencarian">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Data Table Container -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100 text-sm text-gray-500">
                                    <th class="py-4 px-6 font-medium">Nama Admin</th>
                                    <th class="py-4 px-6 font-medium">Status & Role</th>
                                    <th class="py-4 px-6 font-medium">Kunjungan Terakhir</th>
                                    <th class="py-4 px-6 font-medium text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm">
                                @forelse ($admins as $admin)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <!-- Avatar with Online Status Indicator -->
                                            <div class="relative">
                                                <div class="w-10 h-10 rounded-full bg-blue-100 text-rns-blue flex items-center justify-center font-bold font-brand shadow-sm">
                                                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                                                </div>
                                                @if($admin->isOnline())
                                                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full" title="Online Sekarang"></span>
                                                @else
                                                <span class="absolute bottom-0 right-0 w-3 h-3 bg-gray-300 border-2 border-white rounded-full" title="Offline"></span>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $admin->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $admin->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- Status / Role -->
                                    <td class="py-4 px-6">
                                        @if($admin->status === 'pending')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Menunggu Persetujuan
                                            </span>
                                        @else
                                            @if($admin->isOnline())
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                                    Sedang Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    <span class="w-1.5 h-1.5 bg-gray-500 rounded-full mr-1.5"></span>
                                                    Tidak Aktif
                                                </span>
                                            @endif
                                        @endif
                                    </td>
                                    
                                    <!-- Last Visit / Last Login -->
                                    <td class="py-4 px-6">
                                        @if($admin->last_login_at)
                                            <div class="text-sm font-medium text-gray-800">
                                                {{ \Carbon\Carbon::parse($admin->last_login_at)->translatedFormat('d M Y, H:i') }}
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                Pembaruan: {{ \Carbon\Carbon::parse($admin->last_login_at)->diffForHumans() }}
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic text-sm">Belum pernah login</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Action Buttons -->
                                    <td class="py-4 px-6">
                                        <div class="flex items-center justify-end gap-2">
                                            @if($admin->status === 'pending')
                                                <!-- Approve Form -->
                                                <form action="{{ route('admin.approve', $admin->id) }}" method="POST" onsubmit="return confirm('Setujui akun admin ini?');">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1.5 bg-rns-blue hover:bg-blue-800 text-white rounded-md text-sm font-medium transition-colors shadow-sm">
                                                        Terima
                                                    </button>
                                                </form>
                                                
                                                <!-- Reject Form -->
                                                <form action="{{ route('admin.reject', $admin->id) }}" method="POST" onsubmit="return confirm('Tolak dan hapus data admin ini?');">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1.5 bg-white border border-red-200 text-red-600 hover:bg-red-50 rounded-md text-sm font-medium transition-colors">
                                                        Tolak
                                                    </button>
                                                </form>
                                            @else
                                                <!-- Delete Active Form -->
                                                <form action="{{ route('admin.reject', $admin->id) }}" method="POST" onsubmit="return confirm('Hapus permanen akses admin ini dari sistem?');">
                                                    @csrf
                                                    <button type="submit" class="p-1.5 text-red-400 hover:text-red-700 hover:bg-red-50 rounded-md transition-colors" title="Cabut Akses (Hapus)">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-500">
                                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        <p>Belum ada data pendaftar admin yang terdaftar.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Sidebar Toggling Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const toggleBtn = document.getElementById('sidebar-toggle-btn');
            const mainContent = document.getElementById('main-content');
            const topbar = document.getElementById('topbar');

            function toggleSidebar() {
                const isMobile = window.innerWidth < 768;
                
                if (isMobile) {
                    sidebar.classList.toggle('-translate-x-full');
                    if (sidebar.classList.contains('-translate-x-full')) {
                        overlay.classList.add('hidden');
                    } else {
                        overlay.classList.remove('hidden');
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
                    overlay.classList.add('hidden');
                } else {
                    if (!sidebar.classList.contains('-translate-x-full')) {
                        overlay.classList.remove('hidden');
                    }
                }
            });
        });
    </script>
</body>
</html>
