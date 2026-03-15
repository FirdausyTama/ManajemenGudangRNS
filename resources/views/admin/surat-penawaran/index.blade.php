<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Surat Penawaran Harga (SPH) | RNS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Kelola Surat Penawaran Harga (SPH) RNS." />
  <meta name="author" content="Zoyothemes" />
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
      .modal-open { overflow: hidden; }
  </style>

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
              <h4 class="text-2xl font-bold text-gray-800">Surat Penawaran Harga (SPH)</h4>
              <p class="text-gray-500 text-sm mt-1">Buat dan kelola penawaran produk ke instansi tujuan</p>
            </div>
          </div>

          <!-- Search & Filter Card -->
          <form action="{{ route('surat-penawaran.index') }}" method="GET" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row items-center gap-4 mb-6">
              <div class="w-full md:w-44">
                  <select name="period" onchange="this.form.submit()" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm transition-all text-gray-700">
                      <option value="">-- Semua Waktu --</option>
                      <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                      <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                      <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                      <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>Tahun Ini</option>
                  </select>
              </div>

              <div class="w-full md:w-44">
                  <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm transition-all text-gray-700">
              </div>

              <div class="flex-1 w-full relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                      </svg>
                  </div>
                  <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm" placeholder="Cari SPH, customer, atau perihal...">
              </div>

              <div class="flex gap-2 w-full md:w-auto">
                  <button type="submit" class="flex-1 md:flex-none px-5 py-2 bg-rns-blue text-white rounded-lg hover:bg-blue-800 text-sm font-medium shadow-sm transition-all">
                      Cari
                  </button>
                  @if(request()->anyFilled(['search', 'period', 'date']))
                      <a href="{{ route('surat-penawaran.index') }}" class="flex-1 md:flex-none px-5 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium text-center shadow-sm transition-all">
                          Reset
                      </a>
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
                  @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
          @endif

          <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-safe">
              <div class="overflow-x-auto">
                  <table class="w-full text-left border-collapse">
                      <thead class="bg-gray-50/50 text-xs text-gray-500 border-b border-gray-100 uppercase tracking-wider">
                          <tr>
                              <th class="py-4 px-4 font-medium" style="width: 50px;">No</th>
                              <th class="py-4 px-4 font-medium">Nomor SPH</th>
                              <th class="py-4 px-4 font-medium">Tanggal</th>
                              <th class="py-4 px-4 font-medium">Customer / Instansi</th>
                              <th class="py-4 px-4 font-medium">Perihal</th>
                              <th class="py-4 px-4 font-medium text-right">Total</th>
                              <th class="py-4 px-4 font-medium text-center">Aksi</th>
                          </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-100 text-sm">
                          @forelse($surats as $idx => $s)
                          <tr class="hover:bg-gray-50/50 transition-colors">
                              <td class="py-3 px-4 text-gray-500">{{ $surats->firstItem() + $idx }}</td>
                              <td class="py-3 px-4 font-semibold text-gray-800">{{ $s->no_sph }}</td>
                              <td class="py-3 px-4 text-gray-600">{{ \Carbon\Carbon::parse($s->tanggal_sph)->format('d/m/Y') }}</td>
                              <td class="py-3 px-4 text-gray-800">{{ $s->nama_customer }}</td>
                              <td class="py-3 px-4 text-gray-600 italic">{{ Str::limit($s->perihal, 30) }}</td>
                              <td class="py-3 px-4 text-right font-medium text-rns-blue">
                                Rp {{ number_format($s->total_harga, 0, ',', '.') }}
                              </td>
                              <td class="py-3 px-4 text-center">
                                  <div class="flex items-center justify-center gap-2">
                                      <a href="{{ route('surat-penawaran.print', $s->id) }}" target="_blank" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded" title="Cetak SPH">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                      </a>
                                      <button type="button" onclick="editSPH({{ $s->id }})" class="p-1.5 text-orange-600 hover:bg-orange-50 rounded" title="Edit SPH">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                      </button>
                                      <form action="{{ route('surat-penawaran.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus SPH ini?');" class="inline">
                                          @csrf @method('DELETE')
                                          <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded" title="Hapus SPH">
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
                                      <p>Belum ada data Surat Penawaran</p>
                                  </div>
                              </td>
                          </tr>
                          @endforelse
                      </tbody>
                  </table>
              </div>
              <div class="p-4 border-t border-gray-100 flex items-center justify-between">
                  <div class="text-sm text-gray-500">
                      Menampilkan {{ $surats->firstItem() ?? 0 }} sampai {{ $surats->lastItem() ?? 0 }} dari {{ $surats->total() }} data
                  </div>
                  <div>
                      {{ $surats->links('vendor.pagination.custom') }}
                  </div>
              </div>
          </div>
        </div>

        <!-- Add Button -->
        <button type="button" onclick="openModal('addModal')" class="fixed bottom-8 right-8 bg-rns-blue text-white rounded-full p-4 shadow-lg hover:bg-blue-800 transition-all hover:scale-105 z-40 group" title="Buat SPH Baru">
            <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        </button>
    </div>
  </main>

  <!-- Modal components and scripts would go here... -->
  @include('admin.surat-penawaran.modals')

  <script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.classList.add('modal-open');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.classList.remove('modal-open');
    }

    // Edit logic placeholder - will implement in modals file
    function editSPH(id) {
        // Fetch data via AJAX and open edit modal
    }
  </script>
</body>
</html>
