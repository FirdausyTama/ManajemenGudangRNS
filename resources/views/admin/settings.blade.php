<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengaturan Landing Page | Ranay Nusantara Sejathera</title>
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
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 pointer-events-none"></div>

            <div class="max-w-4xl mx-auto space-y-6 relative z-10">
                
                <!-- Page Header -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Pengaturan Halaman Depan (Landing Page)</h2>
                        <p class="text-gray-500 text-sm mt-1">Ubah teks dan gambar konten utama aplikasi tanpa perlu mengubah kode.</p>
                    </div>
                    <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors shadow-sm text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Lihat Halaman
                    </a>
                </div>

                <!-- Alerts -->
                @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm" role="alert">
                    <span class="block sm:inline font-medium">{{ session('success') }}</span>
                </div>
                @endif

                <!-- Form Setting -->
                <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- KELOMPOK: KONTEN HERO (ATAS) -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50/50 border-b border-gray-100 px-6 py-4">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-rns-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Area Hero (Spanduk Atas)
                            </h3>
                        </div>
                        <div class="p-6 space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Utama (Baris 1)</label>
                                <input type="text" name="hero_title_1" value="{{ setting('hero_title_1', 'Solusi Profesional') }}" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue transition-colors">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Utama (Baris 2 Biru)</label>
                                <input type="text" name="hero_title_2" value="{{ setting('hero_title_2', 'Alat Kesehatan Radiologi') }}" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue transition-colors">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sub-Judul (Deskripsi)</label>
                                <textarea name="hero_subtitle" rows="3" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue transition-colors">{{ setting('hero_subtitle', 'Partner terpercaya untuk kebutuhan peralatan medis radiologi Anda. Kami menyediakan produk berkualitas tinggi dengan layanan konsultasi profesional untuk rumah sakit dan fasilitas kesehatan.') }}</textarea>
                            </div>
                            
                            <!-- Upload Banner Slider -->
                            <div class="pt-3 border-t border-gray-100">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Slider Gambar Banner (Maks. 3 Foto)</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Foto 1 -->
                                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-200 relative group">
                                        <label class="block text-xs font-semibold text-gray-600 mb-2">Foto Pertama</label>
                                        @if(setting('hero_image_1'))
                                            <div class="mb-3 relative">
                                                <img src="{{ Storage::url(setting('hero_image_1')) }}" class="h-24 w-full rounded-lg object-cover border border-gray-200 shadow-sm">
                                                <button type="button" onclick="if(confirm('Hapus foto ini?')) { document.getElementById('delete-img-hero_image_1').submit(); }" class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1.5 shadow-md transition-colors" title="Hapus Gambar">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>
                                        @endif
                                        <input type="file" name="hero_image_1" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:font-semibold file:bg-blue-100 file:text-rns-blue transition-colors hover:file:bg-blue-200 cursor-pointer">
                                    </div>
                                    <!-- Foto 2 -->
                                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-200 relative group">
                                        <label class="block text-xs font-semibold text-gray-600 mb-2">Foto Kedua</label>
                                        @if(setting('hero_image_2'))
                                            <div class="mb-3 relative">
                                                <img src="{{ Storage::url(setting('hero_image_2')) }}" class="h-24 w-full rounded-lg object-cover border border-gray-200 shadow-sm">
                                                <button type="button" onclick="if(confirm('Hapus foto ini?')) { document.getElementById('delete-img-hero_image_2').submit(); }" class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1.5 shadow-md transition-colors" title="Hapus Gambar">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>
                                        @endif
                                        <input type="file" name="hero_image_2" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:font-semibold file:bg-blue-100 file:text-rns-blue transition-colors hover:file:bg-blue-200 cursor-pointer">
                                    </div>
                                    <!-- Foto 3 -->
                                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-200 relative group">
                                        <label class="block text-xs font-semibold text-gray-600 mb-2">Foto Ketiga</label>
                                        @if(setting('hero_image_3'))
                                            <div class="mb-3 relative">
                                                <img src="{{ Storage::url(setting('hero_image_3')) }}" class="h-24 w-full rounded-lg object-cover border border-gray-200 shadow-sm">
                                                <button type="button" onclick="if(confirm('Hapus foto ini?')) { document.getElementById('delete-img-hero_image_3').submit(); }" class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1.5 shadow-md transition-colors" title="Hapus Gambar">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>
                                        @endif
                                        <input type="file" name="hero_image_3" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:font-semibold file:bg-blue-100 file:text-rns-blue transition-colors hover:file:bg-blue-200 cursor-pointer">
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-3 flex items-center gap-1">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Gambar akan berganti secara otomatis. Biarkan kosong jika tidak ingin mengubah versi saat ini.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- KELOMPOK: STATISTIK -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50/50 border-b border-gray-100 px-6 py-4">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                Angka Statistik
                            </h3>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Pengalaman</label>
                                <input type="number" name="stat_years" value="{{ setting('stat_years', '3') }}" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Klien Terlayani</label>
                                <input type="number" name="stat_clients" value="{{ setting('stat_clients', '500') }}" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Produk Bergaransi</label>
                                <input type="number" name="stat_products" value="{{ setting('stat_products', '100') }}" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">
                            </div>
                        </div>
                    </div>

                    <!-- KELOMPOK: FITUR (MENGAPA MEMILIH KAMI) -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50/50 border-b border-gray-100 px-6 py-4">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                Fitur (Mengapa Memilih Kami)
                            </h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Kartu 1 -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-5 border-b border-gray-100">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Kartu 1 (Biru)</label>
                                    <input type="text" name="feature_1_title" value="{{ setting('feature_1_title', 'Peralatan Medis Lengkap') }}" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kartu 1</label>
                                    <textarea name="feature_1_desc" rows="2" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">{{ setting('feature_1_desc', 'Menyediakan berbagai jenis alat kesehatan radiologi dan umum dari brand terkemuka dengan teknologi terkini.') }}</textarea>
                                </div>
                            </div>
                            <!-- Kartu 2 -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-5 border-b border-gray-100">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Kartu 2 (Hijau)</label>
                                    <input type="text" name="feature_2_title" value="{{ setting('feature_2_title', 'Terstandarisasi & Berizin') }}" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kartu 2</label>
                                    <textarea name="feature_2_desc" rows="2" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">{{ setting('feature_2_desc', 'Seluruh produk memiliki izin edar resmi dan memenuhi standar keselamatan Kementerian Kesehatan RI.') }}</textarea>
                                </div>
                            </div>
                            <!-- Kartu 3 -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Kartu 3 (Oranye)</label>
                                    <input type="text" name="feature_3_title" value="{{ setting('feature_3_title', 'Layanan Purna Jual') }}" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kartu 3</label>
                                    <textarea name="feature_3_desc" rows="2" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">{{ setting('feature_3_desc', 'Dukungan teknis 24/7, garansi resmi, dan maintenance berkala untuk performa optimal peralatan Anda.') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KELOMPOK: KONTAK & FOOTER -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50/50 border-b border-gray-100 px-6 py-4">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                Info Kontak & Lokasi
                            </h3>
                        </div>
                        <div class="p-6 space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp Admin</label>
                                <input type="text" name="contact_wa" value="{{ setting('contact_wa', '0852-8000-2289') }}" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">
                                <p class="text-xs text-gray-500 mt-1">Gunakan format angka, contoh: 0852-8000-2289</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap Perusahaan</label>
                                <textarea name="company_address" rows="3" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">{{ setting('company_address', 'Jl. Contoh Alamat No. 123, Kelurahan, Kecamatan, Kota Palembang, Kode Pos 30123') }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Perusahaan</label>
                                <input type="email" name="company_email" value="{{ setting('company_email', 'info@rns.co.id') }}" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">
                            </div>
                            <!-- Google Maps -->
                            <div class="pt-2 border-t border-gray-100">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Peta Lokasi Google Maps (Kode Embed iframe)</label>
                                <textarea name="contact_map" rows="3" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue font-mono text-xs">{{ setting('contact_map', '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3967.0370422558197!2d106.14371711430932!3d-6.125717695564887!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e418b1a32a67edf%3A0x6bba31d0411ed026!2sKepuren%2C%20Kec.%20Walantaka%2C%20Kota%20Serang%2C%20Banten!5e0!3m2!1sid!2sid!4v1710000000000!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>') }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Buka Google Maps > Bagikan > Sematkan Peta > Salin HTML `<iframe...>`</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit action -->
                    <div class="pt-4 flex justify-between items-center">
                        <button type="button" onclick="if(confirm('Yakin ingin mereset SEMUA pengaturan ke bawaan awal? Semua teks dan gambar yang diubah akan hilang.')) { document.getElementById('reset-form').submit(); }" class="px-5 py-2.5 bg-white border border-red-200 text-red-600 hover:bg-red-50 hover:border-red-300 font-medium rounded-lg shadow-sm transition-colors flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            Reset ke Semula
                        </button>

                        <button type="submit" class="px-6 py-2.5 bg-rns-blue hover:bg-blue-800 text-white font-medium rounded-lg shadow-md transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

                <!-- Hidden Reset Form -->
                <form id="reset-form" action="{{ route('settings.reset') }}" method="POST" class="hidden">
                    @csrf
                </form>

                <!-- Hidden Delete Image Forms -->
                @if(setting('hero_image_1'))
                <form id="delete-img-hero_image_1" action="{{ route('settings.deleteImage', 'hero_image_1') }}" method="POST" class="hidden">
                    @csrf
                </form>
                @endif
                @if(setting('hero_image_2'))
                <form id="delete-img-hero_image_2" action="{{ route('settings.deleteImage', 'hero_image_2') }}" method="POST" class="hidden">
                    @csrf
                </form>
                @endif
                @if(setting('hero_image_3'))
                <form id="delete-img-hero_image_3" action="{{ route('settings.deleteImage', 'hero_image_3') }}" method="POST" class="hidden">
                    @csrf
                </form>
                @endif
            </div>
        </div>
    </main>

    <!-- Sidebar Toggling Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const toggleBtn = document.getElementById('sidebar-toggle-btn');
            
            function toggleSidebar() {
                if (window.innerWidth < 768) {
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                } else {
                    sidebar.classList.toggle('md:-translate-x-full');
                    sidebar.classList.toggle('md:translate-x-0');
                    document.getElementById('main-content').classList.toggle('md:ml-64');
                    document.getElementById('main-content').classList.toggle('md:ml-0');
                    document.getElementById('topbar').classList.toggle('md:left-64');
                    document.getElementById('topbar').classList.toggle('md:left-0');
                }
            }

            if (toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
            if (overlay) overlay.addEventListener('click', toggleSidebar);
        });
    </script>
</body>
</html>
