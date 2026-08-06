<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Serah Terima Barang | RNS - Rand Nusantara Sejahtera</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Halaman daftar dan pengelolaan surat serah terima barang RNS." />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico?v=2') }}" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: { rns: { blue: '#1e3a8a', light: '#3b82f6' } },
                fontFamily: { sans: ['Poppins', 'sans-serif'] }
            }
        }
    }
  </script>
  <style>body { font-family: 'Poppins', sans-serif; background-color: #F3F4F6; }</style>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="text-gray-800 flex h-screen overflow-x-hidden">
  @include('layouts.navbar')

  <main id="main-content" class="flex-1 md:ml-64 pt-16 flex flex-col h-screen overflow-x-hidden relative transition-all duration-300">
    <div class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8 relative w-full">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto relative z-10">
          <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
              <h4 class="text-2xl font-bold text-gray-800">Surat Serah Terima Barang</h4>
              <p class="text-gray-500 text-sm mt-1">Kelola dokumen serah terima barang ke pelanggan</p>
            </div>
          </div>

          <form action="{{ route('serah-terima.index') }}" method="GET" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:flex-wrap items-center gap-4 mb-6">
              <div class="w-full md:w-auto flex flex-col md:flex-row md:items-center gap-2">
                  <label class="text-sm text-gray-600 font-medium whitespace-nowrap">Bulan:</label>
                  <input type="month" name="month" value="{{ request('month') }}" onchange="this.form.submit()" class="block w-full md:w-40 py-2 px-3 border border-gray-300 bg-white rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm text-gray-700 transition-all">
              </div>
              <div class="w-full md:w-auto flex flex-col md:flex-row md:items-center gap-2">
                  <label class="text-sm text-gray-600 font-medium whitespace-nowrap">Rentang Waktu:</label>
                  <div class="flex flex-col sm:flex-row sm:items-center gap-2 w-full">
                      <input type="date" name="start_date" value="{{ request('start_date') }}" onchange="this.form.submit()" class="block w-full sm:w-36 py-2 px-3 border border-gray-300 bg-white rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm text-gray-700 transition-all">
                      <span class="text-gray-400 font-medium hidden sm:block">-</span>
                      <input type="date" name="end_date" value="{{ request('end_date') }}" onchange="this.form.submit()" class="block w-full sm:w-36 py-2 px-3 border border-gray-300 bg-white rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm text-gray-700 transition-all">
                  </div>
              </div>
              <div class="flex-1 w-full relative min-w-[200px]">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                      </svg>
                  </div>
                  <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm" placeholder="Cari nomor atau penerima...">
              </div>
              <div class="flex gap-2 w-full md:w-auto">
                  <button type="submit" class="flex-1 md:flex-none px-5 py-2 bg-rns-blue text-white rounded-lg hover:bg-blue-800 text-sm font-medium shadow-sm transition-all">Cari</button>
                  @if(request()->anyFilled(['search', 'month', 'start_date', 'end_date']))
                      <a href="{{ url()->current() }}" class="flex-1 md:flex-none px-5 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium text-center shadow-sm transition-all">Reset</a>
                  @endif
              </div>
          </form>

          @if(session('success'))
          <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm mb-6">
              <p class="text-green-700 font-medium">{{ session('success') }}</p>
          </div>
          @endif
          @if($errors->any())
          <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm mb-6">
              <ul class="list-disc list-inside text-red-700 text-sm">
                  @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
              </ul>
          </div>
          @endif

          <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-safe">
              <div class="overflow-x-auto">
                  <table class="w-full text-left border-collapse">
                      <thead class="bg-gray-50/50 text-xs text-gray-500 border-b border-gray-100 uppercase tracking-wider">
                          <tr>
                              <th class="py-4 px-4 font-medium" style="width: 50px;">No</th>
                              <th class="py-4 px-4 font-medium">Nomor Surat</th>
                              <th class="py-4 px-4 font-medium">Tanggal</th>
                              <th class="py-4 px-4 font-medium">Penerima</th>
                              <th class="py-4 px-4 font-medium">Barang</th>
                              <th class="py-4 px-4 font-medium">Dibuat Oleh</th>
                              <th class="py-4 px-4 font-medium text-center">Aksi</th>
                          </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-100 text-sm">
                          @forelse($surat_serah_terimas as $idx => $sst)
                          <tr class="hover:bg-gray-50/50 transition-colors">
                              <td class="py-3 px-4 text-gray-500">{{ $surat_serah_terimas->firstItem() + $idx }}</td>
                              <td class="py-3 px-4 font-semibold text-gray-800">{{ $sst->nomor_surat }}</td>
                              <td class="py-3 px-4 text-gray-600">{{ \Carbon\Carbon::parse($sst->tanggal)->format('d/m/Y') }}</td>
                              <td class="py-3 px-4 text-gray-800">{{ $sst->kepada }}</td>
                              <td class="py-3 px-4 text-gray-800">
                                  @php
                                      $items = is_string($sst->items) ? json_decode($sst->items, true) : $sst->items;
                                      $firstItem = $items ? $items[0]['nama_barang'] : $sst->nama_barang;
                                      $firstQty = $items ? $items[0]['qty'] : $sst->qty;
                                      $moreCount = $items ? count($items) - 1 : 0;
                                  @endphp
                                  {{ Str::limit($firstItem, 30) }} ({{ $firstQty }})
                                  @if($moreCount > 0) <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full ml-1">+{{ $moreCount }} lainnya</span> @endif
                              </td>
                              <td class="py-3 px-4 text-gray-500">{{ $sst->user->name ?? 'Sistem' }}</td>
                              <td class="py-3 px-4 text-center">
                                  <div class="flex items-center justify-center gap-2">
                                      <a href="{{ route('serah-terima.print', $sst->id) }}" target="_blank" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded" title="Cetak Surat">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                      </a>
                                      <form action="{{ route('serah-terima.destroy', $sst->id) }}" method="POST" id="delete-form-{{ $sst->id }}" class="inline">
                                          @csrf @method('DELETE')
                                          <button type="button" onclick="confirmDelete('{{ $sst->id }}')" class="p-1.5 text-red-600 hover:bg-red-50 rounded" title="Hapus Surat">
                                              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                          </button>
                                      </form>
                                  </div>
                              </td>
                          </tr>
                          @empty
                          <tr>
                              <td colspan="7" class="py-8 text-center text-gray-500">
                                  <div class="flex flex-col items-center justify-center">
                                      <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                      <p>Belum ada data surat serah terima barang</p>
                                  </div>
                              </td>
                          </tr>
                          @endforelse
                      </tbody>
                  </table>
              </div>
              <div class="p-4 border-t border-gray-100 flex items-center justify-between">
                  <div class="text-sm text-gray-500">
                      Menampilkan {{ $surat_serah_terimas->firstItem() ?? 0 }} sampai {{ $surat_serah_terimas->lastItem() ?? 0 }} dari {{ $surat_serah_terimas->total() }} data
                  </div>
                  <div>
                      {{ $surat_serah_terimas->links('vendor.pagination.custom') }}
                  </div>
              </div>
          </div>
        </div>

        <button type="button" onclick="openModal('addModal')" class="fixed bottom-8 right-8 bg-rns-blue text-white rounded-full p-4 shadow-lg hover:bg-blue-800 transition-all hover:scale-105 z-40 group" title="Buat Surat Baru">
            <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        </button>
    </div>
  </main>

  <!-- Modal Tambah Surat -->
  <div id="addModal" class="fixed inset-0 bg-gray-900/60 hidden z-[60] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-4xl max-h-[90vh] flex flex-col transform transition-all">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-white rounded-t-xl">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Catat Serah Terima Barang Baru</h3>
                <p class="text-xs text-gray-500 mt-1">Buat dokumen serah terima baru.</p>
            </div>
            <button type="button" onclick="closeModal('addModal')" class="text-gray-400 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-full p-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="p-6 overflow-y-auto bg-gray-50/30 flex-1">
            <form id="addForm" action="{{ route('serah-terima.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Surat <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full rounded-lg border-gray-300 border px-4 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white">
                    </div>
                </div>

                <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm mb-6">
                    <h4 class="font-bold text-gray-800 mb-4">Informasi Customer & Barang</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Auto Fill Opsional -->
                        <div class="md:col-span-2 mb-2 p-3 bg-blue-50 border border-blue-100 rounded-lg">
                            <label class="block text-xs font-medium text-blue-800 mb-1">Auto-fill dari Data Penjualan (Opsional)</label>
                            <input type="text" id="searchPenjualan" list="penjualanList" class="w-full rounded-md border-blue-200 border px-3 py-1.5 text-sm focus:ring-blue-500 focus:border-blue-500 bg-white" placeholder="Ketik No Transaksi untuk isi otomatis..." oninput="onPenjualanSelect(this.value)">
                            <datalist id="penjualanList">
                                @foreach($penjualans as $p)
                                    <option value="{{ $p->no_transaksi }}" data-id="{{ $p->id }}" data-customer="{{ $p->nama_customer }}" data-alamat="{{ $p->alamat_customer }}">{{ $p->nama_customer }}</option>
                                @endforeach
                            </datalist>
                            <input type="hidden" name="penjualan_id" id="penjualanId">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kepada Yth (Customer/RS) <span class="text-red-500">*</span></label>
                            <input type="text" name="kepada" id="inputKepada" required class="w-full rounded-lg border-gray-300 border px-4 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="alamat" id="inputAlamat" rows="2" required class="w-full rounded-lg border-gray-300 border px-4 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white"></textarea>
                        </div>
                        <div class="md:col-span-2 mt-4" id="items-container">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Daftar Barang <span class="text-red-500">*</span></label>
                            
                            <div class="item-row grid grid-cols-1 md:grid-cols-12 gap-3 mb-3 p-3 bg-gray-50 border border-gray-200 rounded-lg relative">
                                <div class="md:col-span-6">
                                    <label class="block text-xs text-gray-500 mb-1">Nama Barang</label>
                                    <input type="text" name="items[0][nama_barang]" required class="w-full rounded-md border-gray-300 border px-3 py-1.5 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white" placeholder="Cth: Xray Mobile...">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs text-gray-500 mb-1">QTY</label>
                                    <input type="text" name="items[0][qty]" required class="w-full rounded-md border-gray-300 border px-3 py-1.5 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white" placeholder="Cth: 1 Unit">
                                </div>
                                <div class="md:col-span-3">
                                    <label class="block text-xs text-gray-500 mb-1">JUMLAH</label>
                                    <input type="text" name="items[0][jumlah]" required class="w-full rounded-md border-gray-300 border px-3 py-1.5 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white" placeholder="Cth: 1 Unit">
                                </div>
                                <div class="md:col-span-1 flex items-end justify-center pb-1">
                                    <button type="button" class="text-red-500 hover:text-red-700 p-1 opacity-50 cursor-not-allowed" disabled title="Tidak bisa dihapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <button type="button" onclick="addItemRow()" class="text-sm text-rns-blue hover:text-blue-800 font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Barang Lain
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-indigo-50 p-5 rounded-lg border border-indigo-100 shadow-sm mt-6">
                    <h4 class="font-bold text-indigo-900 mb-4">Pengirim & Keterangan</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-indigo-900 mb-1">Nama Pengirim <span class="text-red-500">*</span></label>
                            <select name="pengirim" required class="w-full rounded-lg border-indigo-200 border px-4 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                                <option value="Dewi Sulistiowati">Dewi Sulistiowati</option>
                                <option value="Heri Pirdaus, S.Tr.Kes Rad (MRI)">Heri Pirdaus, S.Tr.Kes Rad (MRI)</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-indigo-900 mb-1">Keterangan (Opsional)</label>
                            <textarea name="keterangan" rows="2" class="w-full rounded-lg border-indigo-200 border px-4 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white" placeholder="Contoh: Serah Terima 1 Unit Xray Mobile..."></textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 rounded-b-xl">
            <button type="button" onclick="closeModal('addModal')" class="px-6 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 shadow-sm font-medium text-sm transition-colors">Batal</button>
            <button type="button" onclick="document.getElementById('addForm').submit()" class="px-6 py-2 bg-rns-blue text-white rounded-lg hover:bg-blue-800 shadow-md font-medium text-sm transition-colors flex items-center gap-2">
                Simpan Data
            </button>
        </div>
    </div>
  </div>

  <script>
    function openModal(modalId) { document.getElementById(modalId).classList.remove('hidden'); }
    function closeModal(modalId) { document.getElementById(modalId).classList.add('hidden'); }

    const penjualansData = @json($penjualans);

    function onPenjualanSelect(value) {
        const option = document.querySelector('#penjualanList option[value="' + value + '"]');
        if (option) {
            const pId = option.dataset.id;
            document.getElementById('penjualanId').value = pId;
            document.getElementById('inputKepada').value = option.dataset.customer;
            document.getElementById('inputAlamat').value = option.dataset.alamat;

            // Find the full object and fill items
            const p = penjualansData.find(item => item.id == pId);
            if (p && p.items && p.items.length > 0) {
                const container = document.getElementById('items-container');
                // Remove all existing item rows
                container.querySelectorAll('.item-row').forEach(row => row.remove());
                
                // Add new rows from items
                p.items.forEach((item, index) => {
                    const itemName = item.barang ? item.barang.name : '';
                    const unit = item.barang ? item.barang.unit : 'Unit';
                    
                    const html = `
                        <div class="item-row grid grid-cols-1 md:grid-cols-12 gap-3 mb-3 p-3 bg-gray-50 border border-gray-200 rounded-lg relative" id="row-${index}">
                            <div class="md:col-span-6">
                                <label class="block text-xs text-gray-500 mb-1">Nama Barang</label>
                                <input type="text" name="items[${index}][nama_barang]" value="${itemName}" required class="w-full rounded-md border-gray-300 border px-3 py-1.5 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white" placeholder="Cth: Xray Mobile...">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs text-gray-500 mb-1">QTY</label>
                                <input type="text" name="items[${index}][qty]" value="${item.kuantitas} ${unit}" required class="w-full rounded-md border-gray-300 border px-3 py-1.5 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white" placeholder="Cth: 1 Unit">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-xs text-gray-500 mb-1">JUMLAH</label>
                                <input type="text" name="items[${index}][jumlah]" value="${item.kuantitas} ${unit}" required class="w-full rounded-md border-gray-300 border px-3 py-1.5 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white" placeholder="Cth: 1 Unit">
                            </div>
                            <div class="md:col-span-1 flex items-end justify-center pb-1">
                                <button type="button" onclick="removeItemRow(${index})" class="text-red-500 hover:text-red-700 p-1" title="Hapus Barang">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', html);
                });
            }
        } else {
            document.getElementById('penjualanId').value = '';
        }
    }

    function addItemRow() {
        const container = document.getElementById('items-container');
        const count = container.querySelectorAll('.item-row').length;
        
        const html = `
            <div class="item-row grid grid-cols-1 md:grid-cols-12 gap-3 mb-3 p-3 bg-gray-50 border border-gray-200 rounded-lg relative" id="row-${count}">
                <div class="md:col-span-6">
                    <label class="block text-xs text-gray-500 mb-1">Nama Barang</label>
                    <input type="text" name="items[${count}][nama_barang]" required class="w-full rounded-md border-gray-300 border px-3 py-1.5 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white" placeholder="Cth: Xray Mobile...">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs text-gray-500 mb-1">QTY</label>
                    <input type="text" name="items[${count}][qty]" required class="w-full rounded-md border-gray-300 border px-3 py-1.5 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white" placeholder="Cth: 1 Unit">
                </div>
                <div class="md:col-span-3">
                    <label class="block text-xs text-gray-500 mb-1">JUMLAH</label>
                    <input type="text" name="items[${count}][jumlah]" required class="w-full rounded-md border-gray-300 border px-3 py-1.5 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white" placeholder="Cth: 1 Unit">
                </div>
                <div class="md:col-span-1 flex items-end justify-center pb-1">
                    <button type="button" onclick="removeItemRow(${count})" class="text-red-500 hover:text-red-700 p-1" title="Hapus Barang">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }

    function removeItemRow(id) {
        document.getElementById('row-' + id).remove();
    }

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Surat?',
            text: 'Yakin ingin menghapus surat serah terima ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
  </script>
</body>
</html>
