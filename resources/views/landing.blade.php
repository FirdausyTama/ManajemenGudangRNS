<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT Rand Nusantara Sejahtera - Peralatan Medis Berkualitas</title>
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS (CDN for standalone landing page) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            dark: '#0f204b',
                            blue: '#163b8a',
                            light: '#f4f7fb',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 12px;
        }
        ::-webkit-scrollbar-track {
            background: #f4f7fb; 
        }
        ::-webkit-scrollbar-thumb {
            background-color: #0f204b;
            border-radius: 6px;
            border: 3px solid #f4f7fb;
        }
        ::-webkit-scrollbar-thumb:hover {
            background-color: #163b8a;
        }
        
        .bg-hero-pattern {
            background: linear-gradient(180deg, #f0f4fd 0%, #ffffff 100%);
        }
        @keyframes vibrate {
            0% { transform: rotate(0deg); }
            5% { transform: rotate(10deg); }
            10% { transform: rotate(-10deg); }
            15% { transform: rotate(10deg); }
            20% { transform: rotate(-10deg); }
            25% { transform: rotate(0deg); }
            100% { transform: rotate(0deg); }
        }
        .animate-vibrate {
            animation: vibrate 3s infinite;
        }
    </style>
</head>
<body class="antialiased text-gray-800 bg-white">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative flex justify-end md:justify-between items-center h-20">
                <!-- Logo -->
                <div class="absolute left-1/2 -translate-x-1/2 md:static md:translate-x-0 flex-shrink-0 flex items-center">
                    <img class="h-12 w-auto" src="{{ asset('assets/images/hp-logo.png') }}" alt="PT. RAND" onerror="this.src='https://ui-avatars.com/api/?name=PT+RAND&background=0D8ABC&color=fff&size=150'">
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8">
                    <a href="#beranda" class="nav-link text-brand-blue font-semibold border-b-2 border-brand-blue py-1 text-sm transition">Beranda</a>
                    <a href="#produk" class="nav-link text-gray-500 hover:text-brand-blue font-medium border-b-2 border-transparent py-1 text-sm transition">Produk</a>
                    <a href="#kontak" class="nav-link text-gray-500 hover:text-brand-blue font-medium border-b-2 border-transparent py-1 text-sm transition">Kontak</a>
                </div>

                <!-- CTA Button -->
                <div class="hidden md:flex items-center space-x-4">
                    <button id="install-pwa-btn-desktop" class="inline-flex items-center justify-center px-4 py-2 border border-brand-blue rounded-full shadow-sm text-sm font-semibold text-brand-blue hover:bg-brand-blue hover:text-white transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Install App
                    </button>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-2.5 border border-transparent rounded-full shadow-sm text-sm font-semibold text-white bg-brand-dark hover:bg-brand-blue transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Login
                    </a>
                </div>
                <!-- Mobile menu button -->
                <div class="flex md:hidden items-center">
                    <button type="button" id="mobile-menu-button" class="text-gray-500 hover:text-brand-blue focus:outline-none focus:text-brand-blue p-2">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path id="menu-icon-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path id="menu-icon-close" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-gray-100 shadow-lg">
            <div class="px-4 pt-2 pb-6 space-y-2 sm:px-6">
                <a href="#beranda" class="nav-link-mobile block px-3 py-2 text-brand-blue font-semibold text-base border-l-4 border-brand-blue bg-blue-50 transition">Beranda</a>
                <a href="#produk" class="nav-link-mobile block px-3 py-2 text-gray-500 hover:text-brand-blue hover:bg-blue-50 font-medium text-base border-l-4 border-transparent transition">Produk</a>
                <a href="#kontak" class="nav-link-mobile block px-3 py-2 text-gray-500 hover:text-brand-blue hover:bg-blue-50 font-medium text-base border-l-4 border-transparent transition">Kontak</a>
                
                <div class="pt-4 pb-2 space-y-3">
                    <button id="install-pwa-btn-mobile" class="flex items-center justify-center w-full px-6 py-2.5 border border-brand-blue rounded-full shadow-sm text-sm font-semibold text-brand-blue bg-white hover:bg-brand-blue hover:text-white transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Install App
                    </button>
                    <a href="{{ route('login') }}" class="flex items-center justify-center w-full px-6 py-2.5 border border-transparent rounded-full shadow-sm text-sm font-semibold text-white bg-brand-dark hover:bg-brand-blue transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div id="beranda" class="relative bg-cover bg-right lg:bg-center bg-no-repeat pt-32 pb-24 lg:pt-40 lg:pb-32 overflow-hidden" style="background-image: url('{{ setting('hero_image_1') ? Storage::url(setting('hero_image_1')) : asset('assets/images/background_lp.png') }}');">
        <!-- Overlay (Solid/Transparent on mobile, Gradient on desktop) -->
        <div class="absolute inset-0 bg-white/90 lg:bg-transparent lg:bg-gradient-to-r lg:from-white/95 lg:via-white/80 lg:to-transparent"></div>
        
        <!-- Gradient Overlay (Bottom to Top for Seamless Transition) -->
        <div class="absolute inset-x-0 -bottom-2 h-64 bg-gradient-to-t from-white via-white/95 to-transparent"></div>
        <div class="absolute inset-x-0 bottom-0 h-4 bg-white"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8 items-center">
                <div class="text-center md:max-w-2xl md:mx-auto lg:col-span-7 lg:text-left">
                    <p class="text-xs font-bold tracking-widest text-brand-blue uppercase mb-4">Solusi Kesehatan Terpercaya</p>
                    <h1 class="text-4xl tracking-tight font-extrabold text-brand-dark sm:text-5xl md:text-6xl lg:text-5xl xl:text-6xl leading-tight">
                        {{ setting('hero_title_1', 'Solusi Profesional') }} <span class="text-brand-blue">{{ setting('hero_title_2', 'Alat Kesehatan Radiologi') }}</span>
                    </h1>
                    <p class="mt-6 text-base text-gray-700 sm:text-lg lg:text-xl lg:max-w-xl">
                        {{ setting('hero_subtitle', 'Partner terpercaya untuk kebutuhan peralatan medis radiologi Anda. Kami menyediakan produk berkualitas tinggi dengan layanan konsultasi profesional untuk rumah sakit dan fasilitas kesehatan.') }}
                    </p>
                    <div class="mt-8 sm:max-w-lg sm:mx-auto lg:mx-0 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="#produk" class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-base font-semibold rounded-full text-white bg-brand-dark hover:bg-brand-blue transition-colors shadow-lg">
                            Lihat Produk
                            <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                        <a href="#" class="inline-flex items-center justify-center px-8 py-3.5 border border-gray-200 text-base font-semibold rounded-full text-gray-700 bg-white/90 hover:bg-white transition-colors shadow-sm backdrop-blur-sm">
                            Konsultasi Gratis
                            <svg class="ml-2 -mr-1 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="relative -mt-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-10">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-blue-50 text-brand-blue">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-bold text-brand-dark">{{ setting('feature_1_title', 'Peralatan Medis Lengkap') }}</h3>
                        <p class="mt-1 text-xs text-gray-500">{{ setting('feature_1_desc', 'Menyediakan berbagai jenis alat kesehatan radiologi dan umum dari brand terkemuka dengan teknologi terkini.') }}</p>
                    </div>
                </div>
                <!-- Feature 2 -->
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-blue-50 text-brand-blue">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-bold text-brand-dark">{{ setting('feature_2_title', 'Terstandarisasi & Berizin') }}</h3>
                        <p class="mt-1 text-xs text-gray-500">{{ setting('feature_2_desc', 'Seluruh produk memiliki izin edar resmi dan memenuhi standar keselamatan Kementerian Kesehatan RI.') }}</p>
                    </div>
                </div>
                <!-- Feature 3 -->
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-blue-50 text-brand-blue">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 11V9a6 6 0 00-12 0v2M5 11h2a2 2 0 012 2v3a2 2 0 01-2 2H5a2 2 0 01-2-2v-3a2 2 0 012-2zm12 0h2a2 2 0 012 2v3a2 2 0 01-2 2h-2a2 2 0 01-2-2v-3a2 2 0 012-2zm-3 8H10"></path></svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-bold text-brand-dark">{{ setting('feature_3_title', 'Layanan Purna Jual') }}</h3>
                        <p class="mt-1 text-xs text-gray-500">{{ setting('feature_3_desc', 'Dukungan teknis 24/7, garansi resmi, dan maintenance berkala untuk performa optimal peralatan Anda.') }}</p>
                    </div>
                </div>
                <!-- Feature 4 -->
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-blue-50 text-brand-blue">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-bold text-brand-dark">{{ setting('feature_4_title', 'Pengiriman Cepat') }}</h3>
                        <p class="mt-1 text-xs text-gray-500">{{ setting('feature_4_desc', 'Pengiriman aman dan cepat ke seluruh Indonesia.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div id="produk" class="pt-32 pb-24 bg-gradient-to-b from-white to-brand-light relative -mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <h2 class="text-xs font-bold text-brand-blue tracking-widest uppercase">Kategori Produk</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-brand-dark sm:text-4xl">
                    Temukan Kebutuhan Alat Kesehatan Anda
                </p>
                <p class="mt-4 max-w-2xl text-sm text-gray-500 mx-auto">
                    Kami menyediakan berbagai kategori alat kesehatan untuk memenuhi kebutuhan fasilitas medis, klinik, rumah sakit, hingga laboratorium.
                </p>
            </div>

            <div class="mt-16 grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-6">
                @if(isset($products) && $products->count() > 0)
                    @foreach($products as $product)
                    @php
                        $displayImage = $product->foto_produk;
                        if (!$displayImage && $product->barangMasuks && $product->barangMasuks->count() > 0) {
                            foreach($product->barangMasuks as $bm) {
                                $imgs = is_string($bm->images) ? json_decode($bm->images, true) : $bm->images;
                                if (is_string($imgs)) $imgs = json_decode($imgs, true);
                                if(is_array($imgs) && count($imgs) > 0) {
                                    $displayImage = $imgs[0];
                                    break;
                                }
                            }
                        }
                    @endphp
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-300 flex flex-col h-full overflow-hidden group">
                        <div class="p-6 bg-gray-50 flex items-center justify-center h-40">
                            @if($displayImage)
                                <img src="{{ asset('storage/' . $displayImage) }}" alt="{{ $product->name }}" class="max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-300">
                            @else
                                <!-- Placeholder if no image -->
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(substr($product->name, 0, 2)) }}&background=EBF4FF&color=1E3A8A&size=150&font-size=0.33" alt="{{ $product->name }}" class="h-24 w-24 rounded-full shadow-sm group-hover:scale-110 transition-transform duration-300">
                            @endif
                        </div>
                        <div class="p-4 flex-grow flex flex-col justify-between text-center border-t border-gray-50">
                            <h3 class="text-sm font-bold text-gray-900 mb-4 line-clamp-2">{{ $product->name }}</h3>
                            <a href="#" class="inline-flex items-center justify-center text-xs font-semibold text-brand-blue hover:text-brand-dark transition-colors">
                                Hubungi Kami
                                <svg class="ml-1 w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Dummy Data if no products in database -->
                    @php
                        $dummyCategories = ['Alat Diagnostik', 'Alat Bedah', 'Alat Monitoring', 'Alat Laboratorium', 'Alat Rehabilitasi', 'Sterilisasi'];
                    @endphp
                    @foreach($dummyCategories as $cat)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-300 flex flex-col h-full overflow-hidden group">
                        <div class="p-6 bg-gray-50 flex items-center justify-center h-40">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(substr($cat, 5, 2)) }}&background=EBF4FF&color=1E3A8A&size=150" alt="{{ $cat }}" class="h-24 w-24 rounded-full shadow-sm group-hover:scale-110 transition-transform duration-300">
                        </div>
                        <div class="p-4 flex-grow flex flex-col justify-between text-center border-t border-gray-50">
                            <h3 class="text-sm font-bold text-gray-900 mb-4">{{ $cat }}</h3>
                            <a href="#" class="inline-flex items-center justify-center text-xs font-semibold text-brand-blue hover:text-brand-dark transition-colors">
                                Hubungi Kami
                                <svg class="ml-1 w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-brand-dark">
        <div class="max-w-7xl mx-auto py-10 lg:py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
            <div class="text-center mb-8 lg:mb-12">
                <h2 class="text-xl lg:text-2xl font-bold text-white tracking-wide">Dipercaya oleh Ribuan Fasilitas Kesehatan</h2>
            </div>
            <div class="grid grid-cols-2 gap-4 sm:gap-8 md:grid-cols-4 text-center">
                <div class="flex flex-col items-center">
                    <svg class="h-8 w-8 lg:h-10 lg:w-10 text-white opacity-80 mb-2 lg:mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <p class="text-3xl lg:text-4xl font-extrabold text-white">{{ setting('stat_1_value', '2.500+') }}</p>
                    <p class="mt-1 lg:mt-2 text-xs lg:text-sm font-medium text-blue-200">{{ setting('stat_1_label', 'Fasilitas Kesehatan') }}</p>
                </div>
                <div class="flex flex-col items-center">
                    <svg class="h-8 w-8 lg:h-10 lg:w-10 text-white opacity-80 mb-2 lg:mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <p class="text-3xl lg:text-4xl font-extrabold text-white">{{ setting('stat_2_value', '10.000+') }}</p>
                    <p class="mt-1 lg:mt-2 text-xs lg:text-sm font-medium text-blue-200">{{ setting('stat_2_label', 'Produk Terjual') }}</p>
                </div>
                <div class="flex flex-col items-center">
                    <svg class="h-8 w-8 lg:h-10 lg:w-10 text-white opacity-80 mb-2 lg:mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <p class="text-3xl lg:text-4xl font-extrabold text-white">{{ setting('stat_3_value', '98%') }}</p>
                    <p class="mt-1 lg:mt-2 text-xs lg:text-sm font-medium text-blue-200">{{ setting('stat_3_label', 'Kepuasan Pelanggan') }}</p>
                </div>
                <div class="flex flex-col items-center">
                    <svg class="h-8 w-8 lg:h-10 lg:w-10 text-white opacity-80 mb-2 lg:mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zM12 12h.01"></path></svg>
                    <p class="text-3xl lg:text-4xl font-extrabold text-white">{{ setting('stat_4_value', '24/7') }}</p>
                    <p class="mt-1 lg:mt-2 text-xs lg:text-sm font-medium text-blue-200">{{ setting('stat_4_label', 'Layanan Support') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Brands Section -->
    <div class="bg-white py-12 border-b border-gray-100 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm font-semibold uppercase text-gray-500 tracking-wider mb-8">
                Brand Global Terpercaya
            </p>
        </div>
        
        <style>
            @keyframes scroll-marquee {
                0% { transform: translateX(0); }
                100% { transform: translateX(-50%); }
            }
            .animate-scroll-marquee {
                animation: scroll-marquee 20s linear infinite;
            }
            .animate-scroll-marquee:hover {
                animation-play-state: paused;
            }
        </style>
        
        <div class="relative flex overflow-hidden w-full group">
            <!-- Fade overlays to make it look smooth -->
            <div class="absolute left-0 top-0 bottom-0 w-16 bg-gradient-to-r from-white to-transparent z-10"></div>
            <div class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-white to-transparent z-10"></div>
            
            <div class="flex w-max animate-scroll-marquee items-center">
                <!-- Group 1 -->
                <div class="flex items-center gap-16 md:gap-24 px-8 md:px-12">
                    <h3 class="text-2xl font-black text-red-600">mindray</h3>
                    <h3 class="text-2xl font-black text-blue-800">OMRON</h3>
                    <h3 class="text-2xl font-black text-blue-500">Dräger</h3>
                    <h3 class="text-2xl font-black text-blue-600">PHILIPS</h3>
                    <h3 class="text-xl font-bold text-orange-500 text-center">SIEMENS<br><span class="text-sm">Healthineers</span></h3>
                    <h3 class="text-2xl font-bold text-purple-700">GE Healthcare</h3>
                </div>
                
                <!-- Group 2 (Duplicate for seamless loop) -->
                <div class="flex items-center gap-16 md:gap-24 px-8 md:px-12">
                    <h3 class="text-2xl font-black text-red-600">mindray</h3>
                    <h3 class="text-2xl font-black text-blue-800">OMRON</h3>
                    <h3 class="text-2xl font-black text-blue-500">Dräger</h3>
                    <h3 class="text-2xl font-black text-blue-600">PHILIPS</h3>
                    <h3 class="text-xl font-bold text-orange-500 text-center">SIEMENS<br><span class="text-sm">Healthineers</span></h3>
                    <h3 class="text-2xl font-bold text-purple-700">GE Healthcare</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA & Location Section -->
    <div id="kontak" class="bg-brand-dark py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <!-- CTA Text & Contact Info -->
                <div class="text-center lg:text-left">
                    <h2 class="text-3xl font-extrabold text-white mb-4 leading-tight">Butuh Solusi yang Tepat<br>untuk Fasilitas Kesehatan Anda?</h2>
                    <p class="text-blue-200 text-base mb-8 max-w-lg mx-auto lg:mx-0">Tim kami siap membantu Anda menemukan produk terbaik sesuai kebutuhan. Konsultasi gratis sekarang!</p>
                    
                    @php
                        $waNumber = setting('contact_wa', '085280002289');
                        $cleanWa = preg_replace('/[^0-9]/', '', $waNumber);
                        if (substr($cleanWa, 0, 1) == '0') {
                            $cleanWa = '62' . substr($cleanWa, 1);
                        }
                    @endphp
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start mb-8">
                        <a href="https://wa.me/{{ $cleanWa }}" target="_blank" class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-sm font-bold rounded-full text-brand-dark bg-white hover:bg-gray-50 transition-colors shadow-lg">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                            Konsultasi Gratis
                        </a>
                        <a href="mailto:{{ setting('company_email', 'rand.sejahtera25@gmail.com') }}" class="inline-flex items-center justify-center px-8 py-3.5 border border-blue-400 text-sm font-bold rounded-full text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            {{ setting('company_email', 'rand.sejahtera25@gmail.com') }}
                        </a>
                    </div>
                </div>

                <!-- Google Maps Embed -->
                <div class="h-72 w-full rounded-2xl overflow-hidden shadow-2xl border-4 border-white/10">
                    {!! setting('contact_map', '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1983.5188157016973!2d106.23525822104469!3d-6.125638377002207!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e41f5004d9468f5%3A0xdf1342efde753632!2sPT%20Rand%20Nusantara%20Sejahtera!5e0!3m2!1sid!2sid!4v1784476443455!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>') !!}
                </div>
                
            </div>
        </div>
    </div>
    
    <!-- Simple Footer -->
    <div class="bg-gray-900 py-6 text-center px-4">
        <p class="text-xs text-gray-500">&copy; {{ date('Y') }} {{ setting('hero_title_1', 'PT. RAND Nusantara Sejahtera') }}. All rights reserved.</p>
    </div>

    <!-- Floating WhatsApp Widget -->
        <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
        <!-- Bubbles (Hidden by default, shown by translating up and fading in) -->
        <div id="wa-menu" class="absolute bottom-16 right-0 flex flex-col gap-3 items-end pointer-events-none opacity-0 transition-all duration-300 translate-y-4 mb-2">
            
            <!-- CS -->
            <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode(setting('wa_cs_text', 'Halo RNS, saya ingin bertanya tentang...')) }}" target="_blank" class="flex items-center gap-3 bg-white p-1.5 pl-4 rounded-full shadow-lg border border-gray-100 hover:bg-gray-50 transition-transform hover:scale-105">
                <span class="text-xs font-semibold text-gray-700 whitespace-nowrap">{{ setting('wa_cs_label', 'Hubungi CS') }}</span>
                <div class="bg-green-500 text-white p-2 rounded-full shadow-md">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                </div>
            </a>
            
            <!-- Maintenance -->
            <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode(setting('wa_maint_text', 'Halo RNS, saya butuh layanan Maintenance/Perbaikan...')) }}" target="_blank" class="flex items-center gap-3 bg-white p-1.5 pl-4 rounded-full shadow-lg border border-gray-100 hover:bg-gray-50 transition-transform hover:scale-105">
                <span class="text-xs font-semibold text-gray-700 whitespace-nowrap">{{ setting('wa_maint_label', 'Maintenance') }}</span>
                <div class="bg-green-500 text-white p-2 rounded-full shadow-md">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                </div>
            </a>

            <!-- Order -->
            <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode(setting('wa_order_text', 'Halo RNS, saya ingin melakukan Pemesanan Alat...')) }}" target="_blank" class="flex items-center gap-3 bg-white p-1.5 pl-4 rounded-full shadow-lg border border-gray-100 hover:bg-gray-50 transition-transform hover:scale-105">
                <span class="text-xs font-semibold text-gray-700 whitespace-nowrap">{{ setting('wa_order_label', 'Order Alkes') }}</span>
                <div class="bg-green-500 text-white p-2 rounded-full shadow-md">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                </div>
            </a>
            
        </div>

        <!-- Main Button -->
        <button id="wa-toggle-btn" class="relative bg-green-500 text-white rounded-full p-4 shadow-xl shadow-green-500/30 hover:bg-green-600 transition-all duration-300 flex items-center justify-center animate-vibrate z-10">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
            </svg>
        </button>
    </div>

    <!-- Script for mobile menu toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Mobile Menu Toggle
            const btn = document.getElementById('mobile-menu-button');
            const menu = document.getElementById('mobile-menu');
            const iconOpen = document.getElementById('menu-icon-open');
            const iconClose = document.getElementById('menu-icon-close');

            if (btn) {
                btn.addEventListener('click', () => {
                    menu.classList.toggle('hidden');
                    iconOpen.classList.toggle('hidden');
                    iconClose.classList.toggle('hidden');
                });
            }

            // WhatsApp Widget Toggle
            const waToggleBtn = document.getElementById('wa-toggle-btn');
            const waMenu = document.getElementById('wa-menu');
            
            if (waToggleBtn && waMenu) {
                waToggleBtn.addEventListener('click', () => {
                    waMenu.classList.toggle('opacity-0');
                    waMenu.classList.toggle('pointer-events-none');
                    waMenu.classList.toggle('translate-y-4');
                    waToggleBtn.classList.toggle('animate-vibrate');
                });
                
                document.addEventListener('click', (e) => {
                    if (!waToggleBtn.contains(e.target) && !waMenu.contains(e.target)) {
                        waMenu.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
                        waToggleBtn.classList.add('animate-vibrate');
                    }
                });
            }
            // ScrollSpy Logic
            const sections = [
                document.getElementById("beranda"),
                document.getElementById("produk"),
                document.getElementById("kontak")
            ].filter(Boolean); // Filter out any null elements just in case
            
            const navLinksDesktop = document.querySelectorAll(".nav-link");
            const navLinksMobile = document.querySelectorAll(".nav-link-mobile");

            function updateScrollSpy() {
                let current = "beranda";
                let scrollPos = window.scrollY;

                sections.forEach((section) => {
                    // Check if section is in viewport (considering header height)
                    const sectionTop = section.offsetTop;
                    if (scrollPos >= (sectionTop - 300)) {
                        current = section.getAttribute("id");
                    }
                });

                // Default to beranda if at the very top
                if (scrollPos < 100) current = 'beranda';
                
                // If scrolled to the very bottom, force 'kontak' active
                if ((window.innerHeight + scrollPos) >= document.body.offsetHeight - 50) {
                    current = 'kontak';
                }

                // Update Desktop Navbar
                navLinksDesktop.forEach((link) => {
                    // Reset to inactive state
                    link.classList.remove("text-brand-blue", "font-semibold", "border-brand-blue");
                    link.classList.add("text-gray-500", "font-medium", "border-transparent");
                    
                    // Set active state
                    if (link.getAttribute("href") === `#${current}`) {
                        link.classList.remove("text-gray-500", "font-medium", "border-transparent");
                        link.classList.add("text-brand-blue", "font-semibold", "border-brand-blue");
                    }
                });

                // Update Mobile Navbar
                navLinksMobile.forEach((link) => {
                    // Reset to inactive state
                    link.classList.remove("text-brand-blue", "font-semibold", "border-brand-blue", "bg-blue-50");
                    link.classList.add("text-gray-500", "font-medium", "border-transparent");
                    
                    // Set active state
                    if (link.getAttribute("href") === `#${current}`) {
                        link.classList.remove("text-gray-500", "font-medium", "border-transparent");
                        link.classList.add("text-brand-blue", "font-semibold", "border-brand-blue", "bg-blue-50");
                    }
                });
            }

            window.addEventListener("scroll", updateScrollSpy);
            
            // Run on load after a brief delay to ensure DOM layout is calculated
            setTimeout(updateScrollSpy, 100);
        });

        // Register Service Worker for PWA
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register("{{ asset('sw.js') }}")
                    .then(registration => {
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    })
                    .catch(err => {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            });
        }

        // PWA Install Prompt Logic
        let deferredPrompt;
        const installBtnDesktop = document.getElementById('install-pwa-btn-desktop');
        const installBtnMobile = document.getElementById('install-pwa-btn-mobile');

        window.addEventListener('beforeinstallprompt', (e) => {
            // Prevent the mini-infobar from appearing on mobile
            e.preventDefault();
            // Stash the event so it can be triggered later.
            deferredPrompt = e;
        });

        function installPWA() {
            if (!deferredPrompt) {
                alert('Fitur Install tidak tersedia. Kemungkinan browser Anda tidak mendukung, tidak dalam mode HTTPS/localhost, atau aplikasi sudah terinstall.');
                return;
            }
            
            // Show the install prompt
            deferredPrompt.prompt();
            
            // Wait for the user to respond to the prompt
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted the PWA install prompt');
                    // Hide the install buttons after installation
                    if (installBtnDesktop) installBtnDesktop.classList.add('hidden');
                    if (installBtnMobile) installBtnMobile.classList.add('hidden');
                } else {
                    console.log('User dismissed the PWA install prompt');
                }
                deferredPrompt = null;
            });
        }

        if (installBtnDesktop) installBtnDesktop.addEventListener('click', installPWA);
        if (installBtnMobile) installBtnMobile.addEventListener('click', installPWA);
    </script>
</body>
</html>
