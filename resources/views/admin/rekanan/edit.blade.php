<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Rekanan | Rand Nusantara Sejahtera</title>
    
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
                        <h2 class="text-2xl font-bold text-gray-800">Edit Rekanan: {{ $rekanan->nama_perusahaan }}</h2>
                        <p class="text-gray-500 text-sm mt-1">Perbarui data profil rekanan ini.</p>
                    </div>
                </div>

                @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm mb-6">
                    <ul class="list-disc list-inside text-red-700 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('rekanan.update', $rekanan->id) }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    @csrf
                    @method('PUT')
                    
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-100 pb-2">
                            Profil Perusahaan
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Rekanan <span class="text-red-500">*</span></label>
                                <select name="jenis_rekanan" required class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                                    <option value="Customer" {{ (old('jenis_rekanan', $rekanan->jenis_rekanan) == 'Customer') ? 'selected' : '' }}>Customer</option>
                                    <option value="Supplier" {{ (old('jenis_rekanan', $rekanan->jenis_rekanan) == 'Supplier') ? 'selected' : '' }}>Supplier</option>
                                    <option value="Vendor" {{ (old('jenis_rekanan', $rekanan->jenis_rekanan) == 'Vendor') ? 'selected' : '' }}>Vendor</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan', $rekanan->nama_perusahaan) }}" required class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama PIC</label>
                                <input type="text" name="nama_pic" value="{{ old('nama_pic', $rekanan->nama_pic) }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan PIC</label>
                                <input type="text" name="jabatan_pic" value="{{ old('jabatan_pic', $rekanan->jabatan_pic) }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">No. HP / WhatsApp</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp', $rekanan->no_hp) }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email', $rekanan->email) }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NPWP</label>
                                <input type="text" name="npwp" value="{{ old('npwp', $rekanan->npwp) }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NIB</label>
                                <input type="text" name="nib" value="{{ old('nib', $rekanan->nib) }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">{{ old('alamat', $rekanan->alamat) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kota/Kabupaten</label>
                                <input type="text" name="kota" value="{{ old('kota', $rekanan->kota) }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                                <input type="text" name="provinsi" value="{{ old('provinsi', $rekanan->provinsi) }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                                <input type="text" name="kode_pos" value="{{ old('kode_pos', $rekanan->kode_pos) }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                                <input type="url" name="website" value="{{ old('website', $rekanan->website) }}" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                                <select name="status" required class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">
                                    <option value="Aktif" {{ (old('status', $rekanan->status) == 'Aktif') ? 'selected' : '' }}>Aktif</option>
                                    <option value="Nonaktif" {{ (old('status', $rekanan->status) == 'Nonaktif') ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                            <textarea name="catatan" rows="2" class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-rns-blue focus:border-rns-blue text-sm">{{ old('catatan', $rekanan->catatan) }}</textarea>
                        </div>
                    </div>

                    <div class="p-6 bg-gray-50 flex items-center justify-end gap-3">
                        <a href="{{ route('rekanan.index') }}" class="px-5 py-2.5 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 font-medium text-sm transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-rns-blue text-white rounded-lg hover:bg-blue-800 font-medium text-sm shadow-sm transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Perubahan
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
        });
    </script>
</body>
</html>
