<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Rekanan | Rand Nusantara Sejahtera</title>
    
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

            <div class="max-w-7xl mx-auto space-y-6 relative z-10">
                
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('rekanan.index') }}" class="p-2 bg-white rounded-lg shadow-sm border border-gray-100 text-gray-500 hover:text-rns-blue transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </a>
                        <div>
                            <div class="flex items-center gap-3">
                                <h2 class="text-2xl font-bold text-gray-800">{{ $rekanan->nama_perusahaan }}</h2>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $rekanan->jenis_rekanan }}
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $rekanan->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $rekanan->status }}
                                </span>
                            </div>
                            <p class="text-gray-500 text-sm mt-1">Kode: {{ $rekanan->kode_rekanan }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('rekanan.edit', $rekanan->id) }}" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium shadow-sm transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit Profil
                        </a>
                    </div>
                </div>

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

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column: Info Profil -->
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-100 pb-3">Informasi Kontak & PIC</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Nama PIC</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $rekanan->nama_pic ?: '-' }}</p>
                                    <p class="text-xs text-gray-500">{{ $rekanan->jabatan_pic }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Nomor HP/WA</p>
                                    <p class="text-sm text-gray-800">{{ $rekanan->no_hp ?: '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Email</p>
                                    <p class="text-sm text-gray-800">{{ $rekanan->email ?: '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Website</p>
                                    @if($rekanan->website)
                                        <a href="{{ $rekanan->website }}" target="_blank" class="text-sm text-rns-blue hover:underline">{{ $rekanan->website }}</a>
                                    @else
                                        <p class="text-sm text-gray-800">-</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-100 pb-3">Legalitas & Alamat</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">NPWP</p>
                                    <p class="text-sm text-gray-800 font-medium">{{ $rekanan->npwp ?: '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">NIB</p>
                                    <p class="text-sm text-gray-800 font-medium">{{ $rekanan->nib ?: '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Alamat Lengkap</p>
                                    <p class="text-sm text-gray-800 mt-1">{{ $rekanan->alamat ?: '-' }}</p>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $rekanan->kota }}{{ $rekanan->provinsi ? ', ' . $rekanan->provinsi : '' }} {{ $rekanan->kode_pos }}
                                    </p>
                                </div>
                                @if($rekanan->catatan)
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Catatan Khusus</p>
                                    <p class="text-sm text-gray-800 mt-1 p-3 bg-gray-50 rounded-lg italic">{{ $rekanan->catatan }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Dokumen -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-rns-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Arsip Dokumen ({{ $rekanan->dokumenRekanans->count() }})
                                </h3>
                                <button onclick="document.getElementById('upload-modal').classList.remove('hidden')" class="px-4 py-2 bg-blue-50 text-rns-blue rounded-lg hover:bg-blue-100 text-sm font-medium transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    Upload Baru
                                </button>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-gray-50 border-b border-gray-100 text-sm text-gray-500">
                                            <th class="py-3 px-4 font-medium">Kategori</th>
                                            <th class="py-3 px-4 font-medium">Nama File</th>
                                            <th class="py-3 px-4 font-medium">Ukuran</th>
                                            <th class="py-3 px-4 font-medium">Tanggal</th>
                                            <th class="py-3 px-4 font-medium text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse($rekanan->dokumenRekanans as $doc)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="py-3 px-4">
                                                <span class="text-sm font-medium text-gray-800">{{ $doc->kategori_dokumen }}</span>
                                            </td>
                                            <td class="py-3 px-4">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                    <span class="text-sm text-gray-600 truncate max-w-[200px]" title="{{ $doc->nama_dokumen }}">{{ $doc->nama_dokumen }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4">
                                                <span class="text-xs text-gray-500">{{ $doc->ukuran_file ? number_format($doc->ukuran_file / 1024, 2) . ' KB' : '-' }}</span>
                                            </td>
                                            <td class="py-3 px-4">
                                                <span class="text-xs text-gray-500">{{ $doc->created_at->format('d/m/Y H:i') }}</span>
                                            </td>
                                            <td class="py-3 px-4 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="p-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors" title="Preview/Download">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    </a>
                                                    <a href="{{ Storage::url($doc->file_path) }}" download class="p-1.5 bg-green-50 text-green-600 hover:bg-green-100 rounded-lg transition-colors" title="Download">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                    </a>
                                                    <form action="{{ route('rekanan.destroyDokumen', $doc->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">
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
                                            <td colspan="5" class="py-8 text-center text-sm text-gray-500">
                                                Belum ada dokumen yang diunggah.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Upload Modal -->
    <div id="upload-modal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-gray-900 bg-opacity-50 transition-opacity" onclick="document.getElementById('upload-modal').classList.add('hidden')"></div>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="relative bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg w-full">
                <form action="{{ route('rekanan.uploadDokumen', $rekanan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-900" id="modal-title">Upload Dokumen Baru</h3>
                            <button type="button" onclick="document.getElementById('upload-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        
                        <div id="modal-dokumen-container" class="space-y-4">
                            <div class="dokumen-row-modal">
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori Dokumen</label>
                                    <select name="kategori_dokumen[]" class="w-full rounded-md border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue" required>
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
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih File (Max 20MB)</label>
                                    <input type="file" name="dokumen[]" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-rns-blue hover:file:bg-blue-100 cursor-pointer border border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>
                        
                        <button type="button" onclick="addModalDokumenField()" class="text-rns-blue text-sm font-medium hover:underline mt-2">
                            + Tambah file lainnya
                        </button>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-row-reverse gap-2">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-rns-blue text-base font-medium text-white hover:bg-blue-800 focus:outline-none sm:w-auto sm:text-sm">
                            Upload
                        </button>
                        <button type="button" onclick="document.getElementById('upload-modal').classList.add('hidden')" class="w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



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

        function addModalDokumenField() {
            const container = document.getElementById('modal-dokumen-container');
            const rows = container.getElementsByClassName('dokumen-row-modal');
            const newRow = rows[0].cloneNode(true);
            
            newRow.querySelector('select').selectedIndex = Array.from(newRow.querySelector('select').options).findIndex(opt => opt.value === 'Dokumen Lainnya');
            newRow.querySelector('input[type="file"]').value = '';
            
            // Add a remove button to the new row
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'text-red-500 text-xs font-medium hover:underline block mt-1';
            removeBtn.innerText = '- Hapus form ini';
            removeBtn.onclick = function() { this.parentElement.remove(); };
            newRow.appendChild(removeBtn);

            container.appendChild(newRow);
        }

    </script>
</body>
</html>
