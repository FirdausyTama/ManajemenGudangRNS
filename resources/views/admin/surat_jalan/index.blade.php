<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <title>Surat Jalan | RNS - Ranay Nusantara Sejahtera</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Daftar Surat Jalan Pengiriman RNS" />
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
          <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
              <h4 class="text-2xl font-bold text-gray-800">Surat Jalan Pengiriman</h4>
              <p class="text-gray-500 text-sm mt-1">Kelola dan pantau seluruh surat jalan pengiriman Anda</p>
            </div>
          </div>

          <!-- Search & Filter Card -->
          <form action="{{ route('surat-jalan.index') }}" method="GET" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row items-center gap-4 mb-6">
              <!-- Period Filter -->
              <div class="w-full md:w-44">
                  <select name="period" onchange="this.form.submit()" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm transition-all text-gray-700">
                      <option value="">-- Semua Waktu --</option>
                      <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                      <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                      <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                      <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>Tahun Ini</option>
                  </select>
              </div>

              <!-- Date Picker Filter -->
              <div class="w-full md:w-44">
                  <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm transition-all text-gray-700">
              </div>

              <!-- Search Input -->
              <div class="flex-1 w-full relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                      </svg>
                  </div>
                  <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm" placeholder="Cari SJ atau Penerima...">
              </div>

              <!-- Actions -->
              <div class="flex gap-2 w-full md:w-auto">
                  <button type="submit" class="flex-1 md:flex-none px-5 py-2 bg-rns-blue text-white rounded-lg hover:bg-blue-800 text-sm font-medium shadow-sm transition-all">
                      Cari
                  </button>
                  @if(request()->anyFilled(['search', 'period', 'date']))
                      <a href="{{ route('surat-jalan.index') }}" class="flex-1 md:flex-none px-5 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium text-center shadow-sm transition-all">
                          Reset
                      </a>
                  @endif
              </div>
          </form>

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
                              <th class="py-4 px-4 font-medium">Nomor SJ</th>
                              <th class="py-4 px-4 font-medium">Tanggal</th>
                              <th class="py-4 px-4 font-medium">Nama Penerima</th>
                              <th class="py-4 px-4 font-medium">Pengirim</th>
                              <th class="py-4 px-4 font-medium">Nama Barang</th>
                              <th class="py-4 px-4 font-medium text-center">QTY</th>
                              <th class="py-4 px-4 font-medium text-center">Aksi</th>
                          </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-100 text-sm">
                          @forelse($suratJalans as $idx => $inv)
                          <tr class="hover:bg-gray-50/50 transition-colors">
                              <td class="py-3 px-4 text-gray-500">{{ $suratJalans->firstItem() + $idx }}</td>
                              <td class="py-3 px-4 font-semibold text-gray-800">{{ $inv->nomor_surat_jalan }}</td>
                              <td class="py-3 px-4 text-gray-600">{{ \Carbon\Carbon::parse($inv->tanggal_surat_jalan)->format('d/m/Y') }}</td>
                              <td class="py-3 px-4 text-gray-800 font-medium">{{ $inv->nama_penerima }}</td>
                              <td class="py-3 px-4 text-gray-600">{{ $inv->nama_pengirim }}</td>
                              <td class="py-3 px-4 text-gray-600 truncate max-w-[150px]" title="{{ $inv->nama_barang_jasa }}">{{ $inv->nama_barang_jasa }}</td>
                              <td class="py-3 px-4 text-center font-bold text-gray-700">
                                {{ $inv->qty }}
                              </td>
                              <td class="py-3 px-4 text-center">
                                  <div class="flex items-center justify-center gap-2">
                                      <a href="{{ route('surat-jalan.print', $inv->id) }}" target="_blank" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded" title="Cetak Surat Jalan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                      </a>
                                      <form action="{{ route('surat-jalan.destroy', $inv->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus Surat Jalan ini?');" class="inline">
                                          @csrf @method('DELETE')
                                          <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded" title="Hapus Surat Jalan">
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
                                      <p>Belum ada data surat jalan</p>
                                  </div>
                              </td>
                          </tr>
                          @endforelse
                      </tbody>
                  </table>
              </div>
              <div class="p-4 border-t border-gray-100 flex items-center justify-between">
                  <div class="text-sm text-gray-500">
                      Menampilkan {{ $suratJalans->firstItem() ?? 0 }} sampai {{ $suratJalans->lastItem() ?? 0 }} dari {{ $suratJalans->total() }} data
                  </div>
                  <div>
                      {{ $suratJalans->links('vendor.pagination.custom') }}
                  </div>
              </div>
          </div>
        </div>

        <!-- Add Button -->
        <button type="button" onclick="openModal('addModal')" class="fixed bottom-8 right-8 bg-rns-blue text-white rounded-full p-4 shadow-lg hover:bg-blue-800 transition-all hover:scale-105 z-40 group" title="Tambah Surat Jalan Baru">
            <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        </button>
    </div>
  </main>

  <!-- Modal Tambah Surat Jalan -->
  <div id="addModal" class="fixed inset-0 bg-gray-900/60 hidden z-[60] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-4xl max-h-[90vh] flex flex-col transform transition-all">
        <!-- Header -->
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-white rounded-t-xl">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Buat Surat Jalan Baru</h3>
                <p class="text-xs text-gray-500 mt-1">Buat dokumen surat jalan berdasarkan transaksi pengiriman barang/jasa.</p>
            </div>
            <button type="button" onclick="closeModal('addModal')" class="text-gray-400 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-full p-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Body -->
        <div class="p-6 overflow-y-auto bg-gray-50/30 flex-1">
            <form id="addForm" action="{{ route('surat-jalan.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Keberangkatan / Surat <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_surat_jalan" value="{{ date('Y-m-d') }}" required class="w-full rounded-lg border-gray-300 border px-4 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white">
                    </div>
                </div>

                <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm mb-6">
                    <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Hubungkan dengan Penjualan
                    </h4>
                    
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Transaksi Pembelian <span class="text-red-500">*</span></label>
                            <select name="penjualan_id" id="penjualanId" required class="w-full rounded-lg border-gray-300 border px-4 py-2 text-sm focus:ring-rns-blue focus:border-rns-blue bg-white" onchange="loadPenjualanData(this)">
                                <option value="">-- Manual / Kosongkan --</option>
                                @foreach($penjualans as $p)
                                    <option value="{{ $p->id }}" 
                                        data-customer="{{ $p->nama_customer }}" 
                                        data-telp="{{ $p->no_hp_customer }}" 
                                        data-alamat="{{ $p->alamat_customer }}">
                                        {{ $p->no_transaksi }} - {{ $p->nama_customer }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm">
                    <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                        Rincian Surat Jalan
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pengirim <span class="text-red-500">*</span></label>
                            <input type="text" id="nama_pengirim" name="nama_pengirim" required class="w-full rounded-lg border-gray-300 border px-4 py-2 text-sm focus:ring-rns-blue" value="PT Ranay Nusantara Sejahtera">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima <span class="text-red-500">*</span></label>
                            <input type="text" id="nama_penerima" name="nama_penerima" required class="w-full rounded-lg border-gray-300 border px-4 py-2 text-sm focus:ring-rns-blue" placeholder="Nama instansi/RS...">
                        </div>
                        
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">No Telp Penerima <span class="text-red-500">*</span></label>
                            <input type="text" id="telp_penerima" name="telp_penerima" required class="w-full rounded-lg border-gray-300 border px-4 py-2 text-sm focus:ring-rns-blue" placeholder="08123456789">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Penerima <span class="text-red-500">*</span></label>
                            <textarea id="alamat_penerima" name="alamat_penerima" required class="w-full rounded-lg border-gray-300 border px-4 py-2 text-sm focus:ring-rns-blue" rows="2" placeholder="Alamat lengkap penerima..."></textarea>
                        </div>

                        <div class="md:col-span-2 border-t border-gray-100 pt-3 mt-1"></div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang / Deskripsi Pengiriman <span class="text-red-500">*</span></label>
                            <input type="text" id="nama_barang_jasa" name="nama_barang_jasa" required class="w-full rounded-lg border-gray-300 border px-4 py-2 text-sm focus:ring-rns-blue" placeholder="Contoh: Alat Kesehatan MRI (2 Koli)">
                        </div>

                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">QTY Satuan <span class="text-red-500">*</span></label>
                            <input type="number" id="qty" name="qty" required class="w-full rounded-lg border-gray-300 border px-4 py-2 text-sm focus:ring-rns-blue" placeholder="Jumlah barang">
                        </div>

                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nilai Tagihan / Harga Total <span class="text-red-500">*</span></label>
                            <input type="number" id="jumlah" name="jumlah" required class="w-full rounded-lg border-gray-300 border px-4 py-2 text-sm focus:ring-rns-blue" placeholder="Total harga terkait">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan Tambahan</label>
                            <textarea id="keterangan" name="keterangan" class="w-full rounded-lg border-gray-300 border px-4 py-2 text-sm focus:ring-rns-blue" rows="2" placeholder="Catatan opsional..."></textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 rounded-b-xl">
            <button type="button" onclick="closeModal('addModal')" class="px-6 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 shadow-sm font-medium text-sm transition-colors">Batal</button>
            <button type="button" onclick="document.getElementById('addForm').submit()" class="px-6 py-2 bg-rns-blue text-white rounded-lg hover:bg-blue-800 shadow-md font-medium text-sm transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Buat dan Simpan Surat Jalan
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
        document.getElementById('telp_penerima').value = option.getAttribute('data-telp') || '';
        document.getElementById('alamat_penerima').value = option.getAttribute('data-alamat') || '';
    }


  </script>
</body>
</html>
