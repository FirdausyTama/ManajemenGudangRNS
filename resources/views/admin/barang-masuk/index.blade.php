<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barang Masuk | Ranay Nusantara Sejathera</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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

            <div class="max-w-7xl mx-auto space-y-6 relative z-10">
                
                <!-- Page Header & Action -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Data Barang Masuk</h2>
                        <p class="text-gray-500 text-sm mt-1">Kelola pencatatan stok awal dan penambahan stok barang baru.</p>
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

                <!-- Search Form -->
                <form action="{{ route('barang-masuk.index') }}" method="GET" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-4 mb-6">
                    <div class="flex-1 w-full relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm" placeholder="Cari nama, SKU, atau pabrik...">
                    </div>
                    <div class="flex gap-2 w-full md:w-auto">
                        <button type="submit" class="flex-1 md:flex-none px-5 py-2 bg-rns-blue text-white rounded-lg hover:bg-blue-800 text-sm font-medium">Cari</button>
                        @if(request('search'))
                            <a href="{{ route('barang-masuk.index') }}" class="flex-1 md:flex-none px-5 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium text-center">Reset</a>
                        @endif
                    </div>
                </form>

                <!-- Data Table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100 text-sm text-gray-500">
                                    <th class="py-3 px-4 font-medium">Foto Bukti</th>
                                    <th class="py-3 px-4 font-medium">Nama Barang</th>
                                    <th class="py-3 px-4 font-medium">Tanggal</th>
                                    <th class="py-3 px-4 font-medium">Kode (SKU)</th>
                                    <th class="py-3 px-4 font-medium">Pabrik & Satuan</th>
                                    <th class="py-3 px-4 font-medium">Harga Modal</th>
                                    <th class="py-3 px-4 font-medium">Qty Masuk</th>
                                    <th class="py-3 px-4 font-medium">Diinput Oleh</th>
                                    <th class="py-3 px-4 font-medium text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm">
                                @forelse ($barangMasuks as $bm)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="py-3 px-4">
                                        @if($bm->images)
                                            <div class="flex -space-x-2">
                                                @foreach(array_slice($bm->images, 0, 3) as $img)
                                                    <a href="{{ Storage::url($img) }}" target="_blank">
                                                        <img src="{{ Storage::url($img) }}" class="w-8 h-8 rounded border-2 border-white object-cover">
                                                    </a>
                                                @endforeach
                                                @if(count($bm->images) > 3)
                                                    <div class="w-8 h-8 rounded border-2 border-white bg-gray-100 flex items-center justify-center text-xs font-medium text-gray-600">
                                                        +{{ count($bm->images) - 3 }}
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 font-medium text-gray-800">
                                        {{ $bm->barang->name }}
                                    </td>
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        {{ $bm->incoming_date->format('d M Y') }}
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-600">
                                        {{ $bm->barang->sku }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <div>{{ $bm->barang->factory ?? '-' }}</div>
                                        <div class="text-xs text-gray-500">{{ $bm->barang->unit }}</div>
                                    </td>
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        Rp {{ number_format($bm->barang->purchase_price, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                            +{{ $bm->quantity }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-600 whitespace-nowrap">
                                        {{ $bm->user ? $bm->user->name : '-' }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('monitoring-stok.index', ['search' => $bm->barang->sku]) }}" class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded" title="Lihat di Monitoring">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <button onclick="openEditModal({{ json_encode($bm) }}, {{ json_encode($bm->barang) }})" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>
                                            <form action="{{ route('barang-masuk.destroy', $bm->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini? Stok barang akan dikurangi sesuai qty yang dihapus.');" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="py-8 text-center text-gray-500">Belum ada riwayat barang masuk.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t border-gray-100 flex justify-center">
                        {{ $barangMasuks->withQueryString()->links('vendor.pagination.custom') }}
                    </div>
                </div>

            </div>

            <!-- Floating Action Button -->
            <button onclick="openModal('addModal')" class="fixed bottom-6 right-6 z-40 bg-rns-blue text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg hover:bg-blue-800 hover:shadow-xl transition-all hover:scale-105 group" title="Tambah Barang Masuk">
                <svg class="w-6 h-6 transform group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </button>
            
        </div>
    </main>

    <!-- Modal Tambah Data -->
    <div id="addModal" class="fixed inset-0 bg-gray-900/50 hidden z-50 flex items-center justify-center overflow-y-auto">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl my-8 mx-4 transform transition-all">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center sticky top-0 bg-white rounded-t-xl z-10">
                <h3 class="text-lg font-bold text-gray-800">Tambah Barang Masuk</h3>
                <button onclick="closeModal('addModal')" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <div class="p-6 max-h-[70vh] overflow-y-auto">
                <form action="{{ route('barang-masuk.store') }}" method="POST" enctype="multipart/form-data" id="addForm">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Input</label>
                        <div class="flex gap-4">
                            <label class="flex items-center">
                                <input type="radio" name="is_new_barang" value="1" checked onchange="toggleBarangInput(true)" class="text-rns-blue focus:ring-rns-blue">
                                <span class="ml-2 text-sm text-gray-700">Barang Baru</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="is_new_barang" value="0" onchange="toggleBarangInput(false)" class="text-rns-blue focus:ring-rns-blue">
                                <span class="ml-2 text-sm text-gray-700">Barang Lama (Tambah Stok)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Div Barang Lama -->
                    <div id="divBarangLama" class="hidden space-y-4 mb-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Barang</label>
                            <select name="barang_id" id="old_barang_id" onchange="loadExistingImages(this.value)" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue">
                                <option value="">-- Pilih Barang --</option>
                                @foreach($barangs as $b)
                                    <option value="{{ $b->id }}">{{ $b->sku }} - {{ $b->name }} (Stok: {{ $b->stock }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="existing-images-section" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Barang Tersimpan</label>
                            <div id="existing-images-container" class="flex flex-wrap gap-3">
                                <!-- JS akan menambahkan foto disini -->
                            </div>
                            <p class="text-[10px] text-gray-500 mt-2 italic">*Klik tombol "Hapus" pada foto di atas jika ingin menghapusnya dari sistem. Anda tetap dapat menambahkan foto baru di bawah.</p>
                        </div>
                    </div>

                    <!-- Div Barang Baru -->
                    <div id="divBarangBaru" class="space-y-4 mb-4 bg-blue-50/50 p-4 rounded-lg border border-blue-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">SKU / Kode Barang <span class="text-red-500">*</span></label>
                                <input type="text" name="sku" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue" placeholder="Mis: XRAY-001">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang <span class="text-red-500">*</span></label>
                                <input type="text" name="name" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue" placeholder="Nama produk...">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pabrik Asal</label>
                                <input type="text" name="factory" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Merek</label>
                                <input type="text" name="merek" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue" placeholder="Merek barang (Opsional)">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori Satuan</label>
                                <select name="unit" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue">
                                    <option value="pcs">Pcs</option>
                                    <option value="unit">Unit</option>
                                    <option value="box">Box</option>
                                    <option value="set">Set</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Modal (Rp)</label>
                                <input type="text" id="disp_purchase" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue" placeholder="0" onkeyup="formatCurrency(this, 'real_purchase')">
                                <input type="hidden" name="purchase_price" id="real_purchase">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Jual (Rp)</label>
                                <input type="text" id="disp_selling" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue" placeholder="0" onkeyup="formatCurrency(this, 'real_selling')">
                                <input type="hidden" name="selling_price" id="real_selling">
                            </div>
                        </div>
                    </div>

                    <!-- Input Umum (Pasti ada) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Masuk <span class="text-red-500">*</span></label>
                            <input type="date" name="incoming_date" value="{{ date('Y-m-d') }}" required class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Stok Masuk <span class="text-red-500">*</span></label>
                            <input type="number" name="quantity" min="1" required class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue" placeholder="Qty">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Barang</label>
                        <div id="file-inputs-container" class="space-y-2">
                            <input type="file" name="images[]" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-rns-blue hover:file:bg-blue-100">
                        </div>
                        <button type="button" onclick="addFileInput('file-inputs-container')" class="mt-2 text-xs text-rns-blue font-semibold flex items-center gap-1 hover:text-blue-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Tambah Input Foto Lainnya
                        </button>
                    </div>

                </form>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 rounded-b-xl flex justify-end gap-2 sticky bottom-0">
                <button type="button" onclick="closeModal('addModal')" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium">Batal</button>
                <button type="button" onclick="document.getElementById('addForm').submit()" class="px-4 py-2 bg-rns-blue text-white rounded-lg hover:bg-blue-800 text-sm font-medium">Simpan Data</button>
            </div>
        </div>
    </div>

    <!-- Modal Edit Data -->
    <div id="editModal" class="fixed inset-0 bg-gray-900/50 hidden z-50 flex items-center justify-center overflow-y-auto">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg my-8 mx-4 transform transition-all">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-white rounded-t-xl z-10">
                <h3 class="text-lg font-bold text-gray-800">Edit Riwayat Masuk</h3>
                <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <div class="p-6">
                <div class="mb-4 p-3 bg-blue-50 rounded-lg border border-blue-100">
                    <p class="text-sm text-gray-600">Barang: <span id="editBarangName" class="font-bold text-rns-blue"></span></p>
                    <p class="text-xs text-gray-500 block">Edit ini hanya merubah riwayat stok masuk & tanggal (stok gudang ikut menyesuaikan). Untuk merubah nama dan harga harap ubah dari data master barang.</p>
                </div>
                <form action="" method="POST" enctype="multipart/form-data" id="editForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Masuk</label>
                            <input type="date" name="incoming_date" id="edit_date" required class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kuantitas Masuk</label>
                            <input type="number" name="quantity" id="edit_qty" min="1" required class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue">
                        </div>
                    </div>

                    <div id="existing-edit-images-section" class="mb-4 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Saat Ini</label>
                        <div id="existing-edit-images-container" class="flex flex-wrap gap-3">
                            <!-- JS akan menambahkan foto disini -->
                        </div>
                        <p class="text-[10px] text-gray-500 mt-2 italic">*Klik tombol "Hapus" pada foto di atas jika ingin menghapusnya dari histori ini. Anda tetap dapat menambahkan foto baru di bawah.</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tambah Baru / Ganti Foto (Opsional)</label>
                        <div id="edit-file-inputs-container" class="space-y-2">
                            <input type="file" name="images[]" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-rns-blue hover:file:bg-blue-100">
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <p class="text-[10px] text-gray-400">Biarkan kosong jika tidak mengubah foto.</p>
                            <button type="button" onclick="addFileInput('edit-file-inputs-container')" class="text-xs text-rns-blue font-semibold flex items-center gap-1 hover:text-blue-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Tambah Input
                            </button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 rounded-b-xl flex justify-end gap-2">
                <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium">Batal</button>
                <button type="button" onclick="document.getElementById('editForm').submit()" class="px-4 py-2 bg-rns-blue text-white rounded-lg hover:bg-blue-800 text-sm font-medium">Update Data</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Currency formatter
        function formatCurrency(element, hiddenId) {
            let value = element.value.replace(/[^0-9]/g, '');
            if(hiddenId) {
                document.getElementById(hiddenId).value = value;
            }
            element.value = value ? parseInt(value, 10).toLocaleString('id-ID') : '';
        }

        // Modal Logic
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // prevent scrolling behind
            
            // Reset Dynamic File Inputs when open Add Modal
            if(id === 'addModal') {
                document.getElementById('file-inputs-container').innerHTML = `<input type="file" name="images[]" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-rns-blue hover:file:bg-blue-100">`;
            }
        }
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Data Barang untuk referensi JS
        const barangsData = @json($barangs);

        // Add File Input Dynamically
        function addFileInput(containerId) {
            const container = document.getElementById(containerId);
            const inputHtml = `
                <div class="flex gap-2 items-center">
                    <input type="file" name="images[]" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-rns-blue hover:file:bg-blue-100">
                    <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 p-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', inputHtml);
        }

        function loadExistingImages(barangId) {
            const container = document.getElementById('existing-images-container');
            const section = document.getElementById('existing-images-section');
            container.innerHTML = '';
            
            // Hapus semua input hidden deleted_old_images (reset state)
            document.querySelectorAll('input[name="deleted_old_images[]"]').forEach(el => el.remove());

            if (!barangId) {
                section.classList.add('hidden');
                return;
            }

            const barang = barangsData.find(b => b.id == barangId);
            if (!barang || !barang.barang_masuks || barang.barang_masuks.length === 0) {
                section.classList.add('hidden');
                return;
            }

            // Kumpulkan semua image unik dari histori BarangMasuk item ini
            let allImages = [];
            barang.barang_masuks.forEach(bm => {
                if (bm.images) {
                    let imgs = typeof bm.images === 'string' ? JSON.parse(bm.images) : bm.images;
                    if (typeof imgs === 'string') imgs = JSON.parse(imgs) || []; // antisipasi double stringify
                    if (Array.isArray(imgs)) {
                        imgs.forEach(img => {
                            if (!allImages.includes(img)) allImages.push(img);
                        });
                    }
                }
            });

            if (allImages.length === 0) {
                section.classList.add('hidden');
                return;
            }

            section.classList.remove('hidden');
            
            allImages.forEach(imgPath => {
                const imgId = 'old_img_' + Math.random().toString(36).substr(2, 9);
                const baseUrl = "{{ Storage::url('') }}";
                const html = `
                    <div id="${imgId}" class="relative group mt-2 border border-gray-200 rounded p-1 bg-white">
                        <img src="${baseUrl}${imgPath}" class="w-20 h-20 object-cover rounded">
                        <button type="button" onclick="removeOldImage('${imgPath}', '${imgId}')" class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity" title="Hapus foto ini">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', html);
            });
        }

        function removeOldImage(imgPath, elementId) {
            if (!confirm('Foto ini akan dihapus secara permanen dari galeri produk. Lanjutkan?')) return;
            // Tambahkan hidden input
            const form = document.getElementById('addForm');
            if(form) {
                form.insertAdjacentHTML('beforeend', `<input type="hidden" name="deleted_old_images[]" value="${imgPath}">`);
            }
            // Hilangkan dari tampilan
            document.getElementById(elementId).style.display = 'none';
        }

        // Toggle form (Baru vs Lama)
        function toggleBarangInput(isNew) {
            if(isNew) {
                document.getElementById('divBarangBaru').classList.remove('hidden');
                document.getElementById('divBarangLama').classList.add('hidden');
                document.getElementById('old_barang_id').value = ''; // reset pilihan
                loadExistingImages(''); // hapus preview gambar
            } else {
                document.getElementById('divBarangBaru').classList.add('hidden');
                document.getElementById('divBarangLama').classList.remove('hidden');
            }
        }

        function removeOldEditImage(imgPath, elementId) {
            if (!confirm('Foto ini akan dihapus dari data riwayat masuk ini. Lanjutkan?')) return;
            const form = document.getElementById('editForm');
            if(form) {
                form.insertAdjacentHTML('beforeend', `<input type="hidden" name="deleted_old_images[]" value="${imgPath}">`);
            }
            document.getElementById(elementId).style.display = 'none';
        }

        function openEditModal(bm, barang) {
            document.getElementById('editBarangName').innerText = barang.sku + ' - ' + barang.name;
            document.getElementById('edit_date').value = bm.incoming_date.split('T')[0];
            document.getElementById('edit_qty').value = bm.quantity;
            
            let form = document.getElementById('editForm');
            // Assuming your route is named barang-masuk.update and requires the ID parameter
            form.action = `/admin/barang-masuk/${bm.id}`; 
            
            // Hapus input hidden deleted_old_images (reset state)
            form.querySelectorAll('input[name="deleted_old_images[]"]').forEach(el => el.remove());

            // Render existing images for Edit
            const container = document.getElementById('existing-edit-images-container');
            const section = document.getElementById('existing-edit-images-section');
            container.innerHTML = '';
            
            let imgs = [];
            if (bm.images) {
                if(typeof bm.images === 'string') {
                    imgs = JSON.parse(bm.images) || [];
                } else {
                    imgs = bm.images;
                }
                if (typeof imgs === 'string') imgs = JSON.parse(imgs) || []; // double check
            }

            if (imgs && imgs.length > 0) {
                section.classList.remove('hidden');
                imgs.forEach(imgPath => {
                    const imgId = 'edit_old_img_' + Math.random().toString(36).substr(2, 9);
                    const baseUrl = "{{ Storage::url('') }}";
                    const html = `
                        <div id="${imgId}" class="relative group mt-2 border border-blue-200 rounded p-1 bg-white">
                            <img src="${baseUrl}${imgPath}" class="w-20 h-20 object-cover rounded shadow-sm">
                            <button type="button" onclick="removeOldEditImage('${imgPath}', '${imgId}')" class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center shadow-lg" title="Hapus foto ini">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', html);
                });
            } else {
                section.classList.add('hidden');
            }

            openModal('editModal');
        }

        // Sidebar 
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
                        if (overlay) overlay.classList.add('hidden');
                    } else {
                        if (overlay) overlay.classList.remove('hidden');
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

            // Handle resize to fix states
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) {
                    if (overlay) overlay.classList.add('hidden');
                } else {
                    if (sidebar && !sidebar.classList.contains('-translate-x-full')) {
                        if (overlay) overlay.classList.remove('hidden');
                    }
                }
            });
        });
    </script>
</body>
</html>
