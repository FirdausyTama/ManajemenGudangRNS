<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <title>Service Report | RNS - Rand Nusantara Sejahtera</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Daftar Service Report RNS" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico?v=2') }}" />
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <meta name="theme-color" content="#1e40af">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
              <h4 class="text-2xl font-bold text-gray-800">Service Reports</h4>
              <p class="text-gray-500 text-sm mt-1">Daftar semua laporan service.</p>
            </div>
          </div>

          <!-- Search & Filter Card -->
          <form action="{{ route('service-report.index') }}" method="GET" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row items-center gap-4 mb-6">
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
                  <input type="date" name="date" value="{{ request('date') }}" max="{{ date('Y-m-d') }}" onchange="this.form.submit()" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm transition-all text-gray-700">
              </div>

              <!-- Search Input -->
              <div class="flex-1 w-full relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                      </svg>
                  </div>
                  <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm" placeholder="Cari Service Report atau Customer...">
              </div>

              <!-- Actions -->
              <div class="flex gap-2 w-full md:w-auto">
                  <button type="submit" class="flex-1 md:flex-none px-5 py-2 bg-rns-blue text-white rounded-lg hover:bg-blue-800 text-sm font-medium shadow-sm transition-all">
                      Cari
                  </button>
                  @if(request()->anyFilled(['search', 'period', 'date']))
                      <a href="{{ route('service-report.index') }}" class="flex-1 md:flex-none px-5 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium text-center shadow-sm transition-all">
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

          <!-- Table -->
          <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-safe">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50 text-xs text-gray-500 border-b border-gray-100 uppercase tracking-wider">
                        <tr>
                            <th class="p-4 font-medium" style="width: 50px;">No</th>
                            <th class="p-4 font-medium">No Report</th>
                            <th class="p-4 font-medium">Tanggal Service</th>
                            <th class="p-4 font-medium">Customer & Dept</th>
                            <th class="p-4 font-medium">Data Alat</th>
                            <th class="p-4 font-medium">Problem</th>
                            <th class="p-4 font-medium">Nama Teknisi</th>
                            <th class="p-4 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($service_reports as $idx => $report)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="p-4 text-gray-500">{{ $service_reports->firstItem() + $idx }}</td>
                            <td class="p-4 font-semibold text-gray-800">{{ $report->report_no }}</td>
                            <td class="p-4">
                                <div>{{ \Carbon\Carbon::parse($report->working_start)->format('d M Y') }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">Est: {{ \Carbon\Carbon::parse($report->working_finish)->format('d M Y') }}</div>
                            </td>
                            <td class="p-4">
                                <div class="font-medium text-gray-800">{{ $report->customer_name }}</div>
                                <div class="text-xs text-gray-500">{{ $report->department }}</div>
                            </td>
                            <td class="p-4">
                                <div class="text-gray-800">{{ $report->equipment_brand }}</div>
                                <div class="text-xs text-gray-500">{{ $report->equipment_model }}</div>
                            </td>
                            <td class="p-4 text-gray-600 text-sm">
                                <div class="max-w-[150px] md:max-w-xs truncate" title="{{ $report->problem }}">{{ $report->problem }}</div>
                            </td>
                            <td class="p-4 text-gray-700 font-medium">
                                {{ $report->engineer_name }}
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('service-report.print', $report->id) }}" target="_blank" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Cetak">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    </a>
                                    <form action="{{ route('service-report.destroy', $report->id) }}" method="POST" id="delete-form-{{ $report->id }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $report->id }})" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <p>Belum ada laporan service yang dibuat.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-100 flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    Menampilkan {{ $service_reports->firstItem() ?? 0 }} sampai {{ $service_reports->lastItem() ?? 0 }} dari {{ $service_reports->total() }} data
                </div>
                <div>
                    {{ $service_reports->links('vendor.pagination.custom') }}
                </div>
            </div>
          </div>

        </div>
        
        <!-- Add Button -->
        <button type="button" onclick="openModal('createModal')" class="fixed bottom-4 right-4 md:bottom-8 md:right-8 bg-rns-blue text-white rounded-full p-3 md:p-4 shadow-lg hover:bg-blue-800 transition-all hover:scale-105 z-40 group" title="Tambah Service Report Baru">
            <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        </button>
    </div>
  </main>

  <!-- Create Modal -->
  <div id="createModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
          <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" aria-hidden="true" onclick="closeModal('createModal')"></div>
          <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
          
          <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-gray-100">
              <form action="{{ route('service-report.store') }}" method="POST">
                  @csrf
                  <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                      <h3 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-2" id="modal-title">Buat Service Report Baru</h3>
                      
                      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                          <!-- Customer Info -->
                          <div>
                              <label class="block text-sm font-medium text-gray-700 mb-1">Nama Customer / RS <span class="text-red-500">*</span></label>
                              <input type="text" name="customer_name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rns-blue outline-none transition-all">
                          </div>
                          <div>
                              <label class="block text-sm font-medium text-gray-700 mb-1">Departemen <span class="text-red-500">*</span></label>
                              <input type="text" name="department" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rns-blue outline-none transition-all">
                          </div>
                          <div class="md:col-span-2">
                              <label class="block text-sm font-medium text-gray-700 mb-1">Alamat <span class="text-red-500">*</span></label>
                              <textarea name="customer_address" rows="2" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rns-blue outline-none transition-all"></textarea>
                          </div>
  
                          <!-- Equipment Info -->
                          <div>
                              <label class="block text-sm font-medium text-gray-700 mb-1">Brand / Merk Alat <span class="text-red-500">*</span></label>
                              <input type="text" name="equipment_brand" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rns-blue outline-none transition-all">
                          </div>
                          <div>
                              <label class="block text-sm font-medium text-gray-700 mb-1">Model <span class="text-red-500">*</span></label>
                              <input type="text" name="equipment_model" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rns-blue outline-none transition-all">
                          </div>
  
                          <!-- Service Details -->
                          <div class="md:col-span-2">
                              <label class="block text-sm font-medium text-gray-700 mb-1">Problem (Masalah) <span class="text-red-500">*</span></label>
                              <textarea name="problem" rows="2" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rns-blue outline-none transition-all"></textarea>
                          </div>
                          <div class="md:col-span-2">
                              <label class="block text-sm font-medium text-gray-700 mb-1">Action (Tindakan) <span class="text-red-500">*</span></label>
                              <textarea name="action" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rns-blue outline-none transition-all"></textarea>
                          </div>
                          <div class="md:col-span-2">
                              <label class="block text-sm font-medium text-gray-700 mb-1">Remark (Catatan Khusus)</label>
                              <textarea name="remark" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rns-blue outline-none transition-all"></textarea>
                          </div>
                          <div class="md:col-span-2">
                              <label class="block text-sm font-medium text-gray-700 mb-1">Recommendation (Rekomendasi)</label>
                              <textarea name="recommendation" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rns-blue outline-none transition-all"></textarea>
                          </div>
  
                          <!-- Working Status & Sign -->
                          <div>
                              <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                              <input type="date" name="working_start" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rns-blue outline-none transition-all">
                          </div>
                          <div>
                              <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai <span class="text-red-500">*</span></label>
                              <input type="date" name="working_finish" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rns-blue outline-none transition-all">
                          </div>
                          <div class="md:col-span-2">
                              <label class="block text-sm font-medium text-gray-700 mb-1">Nama Teknisi (Engineer) <span class="text-red-500">*</span></label>
                              <input type="text" name="engineer_name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rns-blue outline-none transition-all">
                          </div>
                      </div>
                  </div>
                  <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3 rounded-b-xl border-t border-gray-100">
                      <button type="submit" class="inline-flex justify-center rounded-lg border border-transparent px-5 py-2.5 bg-rns-blue text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rns-blue transition-all shadow-sm">
                          Simpan Laporan
                      </button>
                      <button type="button" onclick="closeModal('createModal')" class="inline-flex justify-center rounded-lg border border-gray-300 px-5 py-2.5 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-all shadow-sm">
                          Batal
                      </button>
                  </div>
              </form>
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

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Laporan?',
            text: 'Yakin ingin menghapus service report ini?',
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
