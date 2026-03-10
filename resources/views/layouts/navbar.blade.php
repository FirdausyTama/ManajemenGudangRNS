<!-- Mobile Overlay -->
<div id="sidebar-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 hidden md:hidden transition-opacity"></div>

<!-- Sidebar -->
<aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-white shadow-xl flex flex-col h-full z-30 -translate-x-full md:translate-x-0 transition-transform duration-300">
    <div class="h-16 flex items-center justify-center border-b border-gray-100 px-4">
        <img src="{{ asset('assets/images/hp-logo.png') }}" alt="RNS Admin" class="h-10 w-auto">
    </div>
    
    <nav class="flex-grow p-4 space-y-2 overflow-y-auto">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-blue-50 text-rns-blue' : 'text-gray-600 hover:bg-gray-50 hover:text-rns-blue' }} flex items-center gap-3 px-4 py-3 rounded-lg transition-colors font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Dashboard
        </a>
        <a href="{{ route('barang-masuk.index') }}" class="{{ request()->routeIs('barang-masuk.*') ? 'bg-blue-50 text-rns-blue' : 'text-gray-600 hover:bg-gray-50 hover:text-rns-blue' }} flex items-center gap-3 px-4 py-3 rounded-lg transition-colors font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            Barang Masuk
        </a>
        <a href="{{ route('monitoring-stok.index') }}" class="{{ request()->routeIs('monitoring-stok.*') ? 'bg-blue-50 text-rns-blue' : 'text-gray-600 hover:bg-gray-50 hover:text-rns-blue' }} flex items-center gap-3 px-4 py-3 rounded-lg transition-colors font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            Monitoring Stok
        </a>
        <a href="{{ route('penjualan.index') }}" class="{{ request()->routeIs('penjualan.*') ? 'bg-blue-50 text-rns-blue' : 'text-gray-600 hover:bg-gray-50 hover:text-rns-blue' }} flex items-center gap-3 px-4 py-3 rounded-lg transition-colors font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            Kelola Penjualan
        </a>
        <!-- Dokumen Dropdown -->
        <div class="relative x-dropdown">
            <button type="button" class="{{ request()->routeIs('invoice.*') || request()->routeIs('kwitansi.*') || request()->routeIs('surat-jalan.*') ? 'bg-blue-50 text-rns-blue' : 'text-gray-600 hover:bg-gray-50 hover:text-rns-blue' }} flex items-center justify-between w-full gap-3 px-4 py-3 rounded-lg transition-colors font-medium text-left" onclick="this.nextElementSibling.classList.toggle('hidden')">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Dokumen
                </div>
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div class="{{ request()->routeIs('invoice.*') || request()->routeIs('kwitansi.*') || request()->routeIs('surat-jalan.*') ? 'block' : 'hidden' }} pl-11 pr-4 py-2 space-y-1 mt-1 font-medium text-sm">
                <a href="{{ route('invoice.index') }}" class="{{ request()->routeIs('invoice.*') ? 'text-rns-blue font-bold px-2 py-1.5' : 'text-gray-500 hover:text-rns-blue px-2 py-1.5' }} block rounded transition-colors">Surat Invoice</a>
                <a href="{{ route('kwitansi.index') }}" class="{{ request()->routeIs('kwitansi.*') ? 'text-rns-blue font-bold px-2 py-1.5' : 'text-gray-500 hover:text-rns-blue px-2 py-1.5' }} block rounded transition-colors">Surat Kwitansi</a>
                <a href="{{ route('surat-jalan.index') }}" class="{{ request()->routeIs('surat-jalan.*') ? 'text-rns-blue font-bold px-2 py-1.5' : 'text-gray-500 hover:text-rns-blue px-2 py-1.5' }} block rounded transition-colors">Surat Jalan</a>
            </div>
        </div>
        <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-rns-blue rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            Laporan Keuntungan
        </a>
        @if(Auth::check() && Auth::user()->role === 'owner')
        <a href="{{ route('admin.manage') }}" class="{{ request()->routeIs('admin.manage') ? 'bg-blue-50 text-rns-blue' : 'text-gray-600 hover:bg-gray-50 hover:text-rns-blue' }} flex items-center gap-3 px-4 py-3 rounded-lg transition-colors font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Kelola Admin
        </a>
        <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.*') ? 'bg-blue-50 text-rns-blue' : 'text-gray-600 hover:bg-gray-50 hover:text-rns-blue' }} flex items-center gap-3 px-4 py-3 rounded-lg transition-colors font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Setting
        </a>
        @endif
    </nav>
    
    <div class="p-4 border-t border-gray-100">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Keluar Panel
            </button>
        </form>
    </div>
</aside>

<!-- Topbar -->
<header id="topbar" class="fixed top-0 left-0 right-0 md:left-64 h-16 bg-white shadow-sm flex items-center justify-between px-4 z-20 transition-all duration-300">
    <div class="flex items-center gap-2 md:gap-4 whitespace-nowrap">
        <!-- Sidebar Toggle Button -->
        <button id="sidebar-toggle-btn" class="p-2 text-gray-600 hover:text-rns-blue focus:outline-none rounded-md hover:bg-gray-50 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
        <h2 class="text-lg md:text-xl font-semibold text-gray-800">
            <span class="md:hidden">Dashboard</span>
            <span class="hidden md:inline">Dashboard Overview</span>
        </h2>
    </div>
    <div class="flex items-center gap-3 md:gap-4 overflow-hidden">
        <span class="text-sm font-medium text-gray-600 truncate max-w-[100px] md:max-w-none">
            <span class="hidden md:inline">Halo, </span>{{ Auth::user()->name ?? 'Admin' }}
        </span>
        <div class="w-8 h-8 rounded-full bg-rns-blue text-white flex items-center justify-center font-bold shadow flex-shrink-0">
            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
        </div>
    </div>
</header>
