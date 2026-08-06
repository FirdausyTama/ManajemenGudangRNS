<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Rekanan | Rand Nusantara Sejahtera</title>
    
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
    </style>
</head>
<body class="text-gray-800 flex h-screen overflow-x-hidden">

    @include('layouts.navbar')

    <main id="main-content" class="flex-1 md:ml-64 pt-16 flex flex-col h-screen overflow-x-hidden relative transition-all duration-300">
        <div class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8 relative w-full">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 pointer-events-none"></div>

            <div class="max-w-4xl mx-auto space-y-6 relative z-10">
                
                <div class="flex items-center gap-4 mb-6">
                    <a href="{{ route('rekanan.index') }}" class="p-2 bg-white rounded-lg shadow-sm border border-gray-100 text-gray-500 hover:text-rns-blue transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Tambah Rekanan Baru</h2>
                        <p class="text-gray-500 text-sm mt-1">Masukkan data profil dan upload dokumen legalitas rekanan.</p>
                    </div>
                </div>

                @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm mb-6">
                    <div class="flex items-center gap-2 text-red-800 font-bold text-sm mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Mohon periksa kembali form Anda:
                    </div>
                    <ul class="list-disc list-inside text-red-700 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('rekanan.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    @csrf
                    
                    <!-- Section 1: Profil Perusahaan -->
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-blue-50 text-rns-blue flex items-center justify-center font-bold text-sm">1</span>
                            Profil Perusahaan
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Rekanan <span class="text-red-500">*</span></label>
                                <select name="jenis_rekanan" required class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                                    <option value="">Pilih Jenis</option>
                                    <option value="Customer" {{ old('jenis_rekanan') == 'Customer' ? 'selected' : '' }}>Customer</option>
                                    <option value="Supplier" {{ old('jenis_rekanan') == 'Supplier' ? 'selected' : '' }}>Supplier</option>
                                    <option value="Vendor" {{ old('jenis_rekanan') == 'Vendor' ? 'selected' : '' }}>Vendor</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}" required class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm" placeholder="PT / CV / Toko ...">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama PIC (Penanggung Jawab)</label>
                                <input type="text" name="nama_pic" value="{{ old('nama_pic') }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan PIC</label>
                                <input type="text" name="jabatan_pic" value="{{ old('jabatan_pic') }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm" placeholder="Direktur / Staff ...">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">No. HP / WhatsApp</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NPWP</label>
                                <input type="text" name="npwp" value="{{ old('npwp') }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NIB</label>
                                <input type="text" name="nib" value="{{ old('nib') }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">{{ old('alamat') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kota/Kabupaten</label>
                                <input type="text" name="kota" value="{{ old('kota') }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                                <input type="text" name="provinsi" value="{{ old('provinsi') }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                                <input type="text" name="kode_pos" value="{{ old('kode_pos') }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                                <input type="url" name="website" value="{{ old('website') }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm" placeholder="https://...">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                                <select name="status" required class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                                    <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Nonaktif" {{ old('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                            <textarea name="catatan" rows="2" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">{{ old('catatan') }}</textarea>
                        </div>
                    </div>

                    <!-- Section 2: Upload Dokumen -->
                    <div class="p-6 bg-gray-50/50">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-8 h-8 rounded-lg bg-blue-50 text-rns-blue flex items-center justify-center font-bold text-sm">2</span>
                                Upload Dokumen (Opsional)
                            </div>
                            <button type="button" onclick="addDokumenField()" class="px-3 py-1.5 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 text-xs font-medium shadow-sm transition-all">
                                + Tambah File Lainnya
                            </button>
                        </h3>

                        <div id="dokumen-container" class="space-y-4">
                            <!-- Dokumen Row 1 -->
                            <div class="flex flex-col md:flex-row gap-4 items-start md:items-center bg-white p-4 rounded-lg border border-gray-200 shadow-sm dokumen-row">
                                <div class="w-full md:w-1/3">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Kategori Dokumen</label>
                                    <select name="kategori_dokumen[]" class="w-full rounded-md border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue">
                                        <option value="NPWP">NPWP</option>
                                        <option value="NIB">NIB</option>
                                        <option value="Akta Pendirian">Akta Pendirian</option>
                                        <option value="Akta Perubahan">Akta Perubahan</option>
                                        <option value="SK Kemenkumham">SK Kemenkumham</option>
                                        <option value="PKP">PKP</option>
                                        <option value="Izin Usaha">Izin Usaha</option>
                                        <option value="Company Profile">Company Profile</option>
                                        <option value="Katalog Produk">Katalog Produk</option>
                                        <option value="Sertifikat ISO">Sertifikat ISO</option>
                                        <option value="Sertifikat Alat Kesehatan">Sertifikat Alat Kesehatan</option>
                                        <option value="Kontrak Kerja Sama">Kontrak Kerja Sama</option>
                                        <option value="MoU">MoU</option>
                                        <option value="Surat Penunjukan Vendor">Surat Penunjukan Vendor</option>
                                        <option value="Rekening Bank">Rekening Bank</option>
                                        <option value="Logo Perusahaan">Logo Perusahaan</option>
                                        <option value="Dokumen Lainnya" selected>Dokumen Lainnya</option>
                                    </select>
                                </div>
                                <div class="w-full md:w-1/2">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Pilih File (Max 20MB)</label>
                                    <input type="file" name="dokumen[]" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-rns-blue hover:file:bg-blue-100 cursor-pointer border border-gray-300 rounded-md">
                                </div>
                                <div class="w-full md:w-auto pt-5 md:pt-1">
                                    <button type="button" onclick="removeDokumenField(this)" class="p-2 text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-md transition-colors hidden btn-remove">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-100 flex items-center justify-end gap-3 bg-white">
                        <a href="{{ route('rekanan.index') }}" class="px-5 py-2.5 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 font-medium text-sm transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-rns-blue text-white rounded-lg hover:bg-blue-800 font-medium text-sm shadow-sm transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Rekanan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const toggleBtn = document.getElementById('sidebar-toggle-btn');

            function toggleSidebar() {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }

            if(toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
            if(overlay) overlay.addEventListener('click', toggleSidebar);
            updateRemoveButtons();
        });

        function addDokumenField() {
            const container = document.getElementById('dokumen-container');
            const rows = container.getElementsByClassName('dokumen-row');
            const newRow = rows[0].cloneNode(true);
            
            // Reset values
            newRow.querySelector('select').selectedIndex = Array.from(newRow.querySelector('select').options).findIndex(opt => opt.value === 'Dokumen Lainnya');
            newRow.querySelector('input[type="file"]').value = '';
            
            container.appendChild(newRow);
            updateRemoveButtons();
        }

        function removeDokumenField(btn) {
            const container = document.getElementById('dokumen-container');
            if (container.getElementsByClassName('dokumen-row').length > 1) {
                btn.closest('.dokumen-row').remove();
            }
            updateRemoveButtons();
        }

        function updateRemoveButtons() {
            const container = document.getElementById('dokumen-container');
            const btns = container.getElementsByClassName('btn-remove');
            if (btns.length > 1) {
                Array.from(btns).forEach(btn => btn.classList.remove('hidden'));
            } else {
                btns[0].classList.add('hidden');
            }
        }
    </script>
</body>
</html>
