<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengaturan Landing Page | Rand Nusantara Sejahtera</title>
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
                    <a href="{{ url('/') }}" target="_blank" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors shadow-sm text-sm font-medium">
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
                                <input type="text" name="hero_title_1" value="{{ setting('hero_title_1', 'Solusi Alat Kesehatan') }}" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue transition-colors">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Utama (Baris 2 Biru)</label>
                                <input type="text" name="hero_title_2" value="{{ setting('hero_title_2', 'Profesional & Terpercaya') }}" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue transition-colors">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sub-Judul (Deskripsi)</label>
                                <textarea name="hero_subtitle" rows="3" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue transition-colors">{{ setting('hero_subtitle', 'Mitra penyedia peralatan medis berstandar internasional untuk mendukung keunggulan layanan fasilitas kesehatan di seluruh Indonesia.') }}</textarea>
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
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="flex gap-3">
                                <div class="w-1/3">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Angka 1</label>
                                    <input type="text" name="stat_1_value" value="{{ setting('stat_1_value', '2.500+') }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                                </div>
                                <div class="w-2/3">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Label Stat 1</label>
                                    <input type="text" name="stat_1_label" value="{{ setting('stat_1_label', 'Fasilitas Kesehatan') }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="w-1/3">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Angka 2</label>
                                    <input type="text" name="stat_2_value" value="{{ setting('stat_2_value', '10.000+') }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                                </div>
                                <div class="w-2/3">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Label Stat 2</label>
                                    <input type="text" name="stat_2_label" value="{{ setting('stat_2_label', 'Produk Terjual') }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="w-1/3">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Angka 3</label>
                                    <input type="text" name="stat_3_value" value="{{ setting('stat_3_value', '98%') }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                                </div>
                                <div class="w-2/3">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Label Stat 3</label>
                                    <input type="text" name="stat_3_label" value="{{ setting('stat_3_label', 'Kepuasan Pelanggan') }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="w-1/3">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Angka 4</label>
                                    <input type="text" name="stat_4_value" value="{{ setting('stat_4_value', '24/7') }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                                </div>
                                <div class="w-2/3">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Label Stat 4</label>
                                    <input type="text" name="stat_4_label" value="{{ setting('stat_4_label', 'Layanan Support') }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                                </div>
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
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Kartu 1</label>
                                    <input type="text" name="feature_1_title" value="{{ setting('feature_1_title', 'Kualitas Premium') }}" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kartu 1</label>
                                    <textarea name="feature_1_desc" rows="2" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">{{ setting('feature_1_desc', 'Produk berkualitas tinggi dengan standar internasional.') }}</textarea>
                                </div>
                            </div>
                            <!-- Kartu 2 -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-5 border-b border-gray-100">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Kartu 2</label>
                                    <input type="text" name="feature_2_title" value="{{ setting('feature_2_title', 'Garansi Resmi') }}" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kartu 2</label>
                                    <textarea name="feature_2_desc" rows="2" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">{{ setting('feature_2_desc', 'Garansi resmi dan layanan purna jual terpercaya.') }}</textarea>
                                </div>
                            </div>
                            <!-- Kartu 3 -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-5 border-b border-gray-100">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Kartu 3</label>
                                    <input type="text" name="feature_3_title" value="{{ setting('feature_3_title', 'Konsultasi Ahli') }}" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kartu 3</label>
                                    <textarea name="feature_3_desc" rows="2" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">{{ setting('feature_3_desc', 'Dukungan dari tim profesional berpengalaman.') }}</textarea>
                                </div>
                            </div>
                            <!-- Kartu 4 -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Kartu 4</label>
                                    <input type="text" name="feature_4_title" value="{{ setting('feature_4_title', 'Pengiriman Cepat') }}" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kartu 4</label>
                                    <textarea name="feature_4_desc" rows="2" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">{{ setting('feature_4_desc', 'Pengiriman aman dan cepat ke seluruh Indonesia.') }}</textarea>
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

                    <!-- KELOMPOK: TOMBOL WHATSAPP MENGAMBANG -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50/50 border-b border-gray-100 px-6 py-4">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                                Tombol WhatsApp Mengambang (Pojok Kanan Bawah)
                            </h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Tombol 1 -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-5 border-b border-gray-100">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Label Tombol 1</label>
                                    <input type="text" name="wa_order_label" value="{{ setting('wa_order_label', 'Order Alkes') }}" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pesan Otomatis (Saat diklik)</label>
                                    <textarea name="wa_order_text" rows="2" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">{{ setting('wa_order_text', 'Halo RNS, saya ingin melakukan Pemesanan Alat...') }}</textarea>
                                </div>
                            </div>
                            <!-- Tombol 2 -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-5 border-b border-gray-100">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Label Tombol 2</label>
                                    <input type="text" name="wa_maint_label" value="{{ setting('wa_maint_label', 'Maintenance') }}" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pesan Otomatis (Saat diklik)</label>
                                    <textarea name="wa_maint_text" rows="2" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">{{ setting('wa_maint_text', 'Halo RNS, saya butuh layanan Maintenance/Perbaikan...') }}</textarea>
                                </div>
                            </div>
                            <!-- Tombol 3 -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Label Tombol 3</label>
                                    <input type="text" name="wa_cs_label" value="{{ setting('wa_cs_label', 'Hubungi CS') }}" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pesan Otomatis (Saat diklik)</label>
                                    <textarea name="wa_cs_text" rows="2" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue">{{ setting('wa_cs_text', 'Halo RNS, saya ingin berkonsultasi dengan Customer Service...') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit action -->
                    <div class="pt-4 flex flex-col-reverse md:flex-row justify-between items-center gap-4">
                        <button type="button" onclick="if(confirm('Yakin ingin mereset SEMUA pengaturan ke bawaan awal? Semua teks dan gambar yang diubah akan hilang.')) { document.getElementById('reset-form').submit(); }" class="w-full md:w-auto justify-center px-5 py-2.5 bg-white border border-red-200 text-red-600 hover:bg-red-50 hover:border-red-300 font-medium rounded-lg shadow-sm transition-colors flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            Reset ke Semula
                        </button>

                        <button type="submit" class="w-full md:w-auto justify-center px-6 py-2.5 bg-rns-blue hover:bg-blue-800 text-white font-medium rounded-lg shadow-md transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

                <!-- Hidden Reset Form -->
                <form id="reset-form" action="{{ route('settings.reset') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </main>


</body>
</html>
