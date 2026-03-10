<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <title>Kwitansi | RNS - Ranay Nusantara Sejahtera</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Daftar Kwitansi Pembayaran RNS" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />

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
        <!-- Decoration -->
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto relative z-10">
          <div class="py-3 flex flex-col sm:flex-row justify-between items-center mb-6">
            <div>
              <h4 class="text-2xl font-bold text-gray-800">Kwitansi Dokumen</h4>
              <p class="text-gray-500 text-sm">Kelola dan pantau seluruh kwitansi transaksi Anda</p>
            </div>
            
            <div class="mt-4 sm:mt-0 flex gap-2">
              <form action="{{ route('kwitansi.index') }}" method="GET" class="flex items-center">
                 <select name="filter" class="rounded-l-lg border-gray-300 border-y border-l px-3 py-2 text-sm focus:ring-rns-blue outline-none" onchange="this.form.submit()">
                    <option value="Semua Waktu" {{ $filter == 'Semua Waktu' ? 'selected' : '' }}>Semua Waktu</option>
                    <option value="Hari Ini" {{ $filter == 'Hari Ini' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="Minggu Ini" {{ $filter == 'Minggu Ini' ? 'selected' : '' }}>Minggu Ini</option>
                    <option value="Bulan Ini" {{ $filter == 'Bulan Ini' ? 'selected' : '' }}>Bulan Ini</option>
                 </select>
                 <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari Kwitansi/Klien..." class="border border-gray-300 px-3 py-2 text-sm outline-none focus:ring-rns-blue" />
                 <button type="submit" class="bg-rns-blue text-white px-3 py-2 rounded-r-lg hover:bg-blue-800 transition-colors">
                   Cari
                 </button>
              </form>
            </div>
          </div>

          <!-- Alerts -->
          @if(session('success'))
          <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm mb-6">
              <p class="text-green-700 font-medium">{{ session('success') }}</p>
          </div>
          @endif
          @if($errors->any())
          <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm mb-6">
              <ul class="list-disc list-inside text-red-700 text-sm">
                  @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
          @endif

          <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-safe">
              <div class="overflow-x-auto">
                  <table class="w-full text-left border-collapse whitespace-nowrap">
                      <thead class="bg-gray-50/50 text-xs text-gray-500 border-b border-gray-100 uppercase tracking-wider">
                          <tr>
                              <th class="py-4 px-4 font-medium" style="width: 50px;">No</th>
                              <th class="py-4 px-4 font-medium">Nomor Kwitansi</th>
                              <th class="py-4 px-4 font-medium">Tanggal</th>
                              <th class="py-4 px-4 font-medium">Nama Klien</th>
                              <th class="py-4 px-4 font-medium">Keterangan</th>
                              <th class="py-4 px-4 font-medium text-right">Nilai Tagihan</th>
                              <th class="py-4 px-4 font-medium">Dibuat Oleh</th>
                              <th class="py-4 px-4 font-medium text-center">Aksi</th>
                          </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-100 text-sm">
                          @forelse($kwitansis as $idx => $inv)
                          <tr class="hover:bg-gray-50/50 transition-colors">
                              <td class="py-3 px-4 text-gray-500">{{ $kwitansis->firstItem() + $idx }}</td>
                              <td class="py-3 px-4 font-semibold text-gray-800">{{ $inv->nomor_kwitansi }}</td>
                              <td class="py-3 px-4 text-gray-600">{{ \Carbon\Carbon::parse($inv->tanggal_kwitansi)->format('d/m/Y') }}</td>
                              <td class="py-3 px-4 text-gray-800">{{ $inv->nama_penerima }}</td>
                              <td class="py-3 px-4 text-gray-600 truncate max-w-[150px]" title="{{ $inv->keterangan }}">{{ $inv->keterangan }}</td>
                              <td class="py-3 px-4 text-right font-medium text-rns-blue">
                                Rp {{ number_format($inv->total_pembayaran, 0, ',', '.') }}
                              </td>
                              <td class="py-3 px-4 text-gray-500">{{ $inv->user->name ?? 'Sistem' }}</td>
                              <td class="py-3 px-4 text-center">
                                  <div class="flex items-center justify-center gap-2">
                                      <a href="{{ route('kwitansi.print', $inv->id) }}" target="_blank" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded" title="Cetak Kwitansi">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                      </a>
                                      <form action="{{ route('kwitansi.destroy', $inv->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kwitansi ini?');" class="inline">
                                          @csrf @method('DELETE')
                                          <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded" title="Hapus Kwitansi">
                                              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                          </button>
                                      </form>
                                  </div>
                              </td>
                          </tr>
                          @empty
                          <tr>
                              <td colspan="8" class="py-8 text-center text-gray-500">
                                  <div class="flex flex-col items-center justify-center">
                                      <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                      <p>Belum ada data surat kwitansi</p>
                                  </div>
                              </td>
                          </tr>
                          @endforelse
                      </tbody>
                  </table>
              </div>
              <div class="p-4 border-t border-gray-100 flex items-center justify-between">
                  <div class="text-sm text-gray-500">
                      Menampilkan {{ $kwitansis->firstItem() ?? 0 }} sampai {{ $kwitansis->lastItem() ?? 0 }} dari {{ $kwitansis->total() }} data
                  </div>
                  <div>
                      {{ $kwitansis->links('vendor.pagination.custom') }}
                  </div>
              </div>
          </div>
        </div>

        <!-- Add Button -->
        <button type="button" onclick="openModal('addModal')" class="fixed bottom-8 right-8 bg-rns-blue text-white rounded-full p-4 shadow-lg hover:bg-blue-800 transition-all hover:scale-105 z-40 group" title="Tambah Kwitansi Baru">
            <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        </button>
    </div>
  </main>

  <!-- Modal Tambah Kwitansi -->
  <div id="addModal" class="fixed inset-0 bg-gray-900/60 hidden z-[60] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-4xl max-h-[90vh] flex flex-col transform transition-all">
        <!-- Header -->
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-white rounded-t-xl">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Catat Kwitansi Baru</h3>
                <p class="text-xs text-gray-500 mt-1">Buat dokumen kwitansi berdasarkan transaksi penjualan secara terstruktur.</p>
            </div>
            <button type="button" onclick="closeModal('addModal')" class="text-gray-400 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-full p-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Body -->
        <div class="p-6 overflow-y-auto bg-gray-50/30 flex-1">
            <form id="addForm" action="{{ route('kwitansi.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kwitansi <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_kwitansi" value="{{ date('Y-m-d') }}" required class="w-full rounded-lg border-gray-300 border px-4 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white">
                    </div>
                </div>

                <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm mb-6">
                    <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Hubungkan Penjualan
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Transaksi Pembelian <span class="text-red-500">*</span></label>
                            <select name="penjualan_id" id="penjualanId" required class="w-full rounded-lg border-gray-300 border px-4 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white" onchange="loadPenjualanData(this)">
                                <option value="">-- Manual / Kosongkan --</option>
                                @foreach($penjualans as $p)
                                    @if($p->status_pembayaran !== 'belum lunas')
                                    <option value="{{ $p->id }}" 
                                        data-customer="{{ $p->nama_customer }}" 
                                        data-alamat="{{ $p->alamat_customer }}"
                                        data-total="{{ $p->total_keseluruhan }}">
                                        {{ $p->no_transaksi }} - {{ $p->nama_customer }} (Rp {{ number_format($p->total_keseluruhan, 0, ',', '.') }})
                                    </option>
                                    @endif
                                @endforeach
                            </select>
                            <p class="text-[11px] text-gray-500 mt-1">Hanya bisa mencetak Kwitansi untuk penjualan yang sudah Cicilan atau Lunas.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm mb-6">
                    <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                        Rincian Kwitansi
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Customer / Instansi Penerima <span class="text-red-500">*</span></label>
                            <input type="text" id="nama_penerima" name="nama_penerima" required class="w-full rounded-lg border-gray-300 border px-4 py-2 text-sm focus:ring-rns-blue" placeholder="Nama instansi (Telah terima dari)">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Penerima <span class="text-red-500">*</span></label>
                            <input type="text" id="alamat_penerima" name="alamat_penerima" required class="w-full rounded-lg border-gray-300 border px-4 py-2 text-sm focus:ring-rns-blue" placeholder="Alamat lengkap...">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Banyaknya Uang (Terbilang) <span class="text-red-500">*</span></label>
                            <input type="text" id="total_bilangan" name="total_bilangan" class="w-full rounded-lg border-gray-300 border px-4 py-2 text-sm focus:ring-rns-blue" placeholder="Misal: Tiga Juta Lima Ratus Ribu Rupiah (Kosongkan bila ingin otomatis)">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Untuk Pembayaran <span class="text-red-500">*</span></label>
                            <textarea id="keterangan" name="keterangan" required class="w-full rounded-lg border-gray-300 border px-4 py-2 text-sm focus:ring-rns-blue" rows="2" placeholder="Sebutkan detail barang atau jasa yang dibayar..."></textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Total Jumlah Harga (Angka) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-2.5 text-gray-500">Rp</span>
                                <input type="number" id="total_pembayaran" name="total_pembayaran" required class="w-full rounded-lg border-gray-300 border pl-10 pr-4 py-2 text-sm focus:ring-rns-blue font-bold text-lg" placeholder="10000000">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-indigo-50 p-5 rounded-lg border border-indigo-100 shadow-sm">
                    <h4 class="font-bold text-indigo-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Penandatangan Kwitansi
                    </h4>
                    
                    <div>
                        <label class="block text-sm font-medium text-indigo-900 mb-1">Nama Penandatangan <span class="text-red-500">*</span></label>
                        <select name="penandatangan" required class="w-full rounded-lg border-indigo-200 border px-4 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                            <option value="">Pilih Penandatangan...</option>
                            <option value="Dewi Sulistiowati">Dewi Sulistiowati</option>
                            <option value="Heri Pirdaus, S.Tr.Kes Rad (MRI)">Heri Pirdaus, S.Tr.Kes Rad (MRI)</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 rounded-b-xl">
            <button type="button" onclick="closeModal('addModal')" class="px-6 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 shadow-sm font-medium text-sm transition-colors">Batal</button>
            <button type="button" onclick="document.getElementById('addForm').submit()" class="px-6 py-2 bg-rns-blue text-white rounded-lg hover:bg-blue-800 shadow-md font-medium text-sm transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Buat dan Simpan Kwitansi
            </button>
        </div>
    </div>
  </div>

  <script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function loadPenjualanData(selectElement) {
        const option = selectElement.options[selectElement.selectedIndex];
        if(!option.value) return;

        document.getElementById('nama_penerima').value = option.getAttribute('data-customer');
        document.getElementById('alamat_penerima').value = option.getAttribute('data-alamat') || '';
        document.getElementById('total_pembayaran').value = option.getAttribute('data-total');
        document.getElementById('keterangan').value = 'Pembayaran untuk transaksi pembelian nomor ' + option.text.split(' - ')[0];

        // Basic auto terbilang wrapper helper logic if user wants to use js (optional, user can fill manually for clarity)
    }

    // Sidebar logic 
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const topbar = document.getElementById('topbar');
        const toggleBtn = document.getElementById('sidebar-toggle-btn');
        const overlay = document.getElementById('sidebar-overlay');

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
    });
  </script>
</body>
</html>
