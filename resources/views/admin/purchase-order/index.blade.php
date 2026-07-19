<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Purchase Order | RNS - Rand Nusantara Sejahtera</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Halaman daftar dan pengelolaan Purchase Order RNS." />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico?v=2') }}" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F3F4F6; }
        .modal-open { overflow: hidden; }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        rns: { blue: '#1e3a8a', light: '#3b82f6', }
                    }
                }
            }
        }
    </script>
</head>
<body class="text-gray-800 flex h-screen overflow-x-hidden">

    @include('layouts.navbar')

    <main id="main-content" class="flex-1 md:ml-64 pt-16 flex flex-col h-screen overflow-x-hidden relative transition-all duration-300">
        <div class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8 relative w-full">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto relative z-10">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div>
                        <h4 class="text-2xl font-bold text-gray-800">Purchase Order (PO)</h4>
                        <p class="text-gray-500 text-sm mt-1">Buat dan kelola dokumen Purchase Order</p>
                    </div>
                </div>

                <!-- Search & Filter Card -->
                <form action="{{ route('purchase-order.index') }}" method="GET" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row items-center gap-4 mb-6">
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
                        <input type="date" name="date" value="{{ request('date') }}" max="{{ date('Y-m-d') }}" onchange="this.form.submit()" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm transition-all text-gray-700">
                    </div>

                    <div class="flex-1 w-full relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-rns-blue sm:text-sm" placeholder="Cari No. PO atau Nama Perusahaan...">
                    </div>

                    <div class="flex gap-2 w-full md:w-auto">
                        <button type="submit" class="flex-1 md:flex-none px-5 py-2 bg-rns-blue text-white rounded-lg hover:bg-blue-800 text-sm font-medium shadow-sm transition-all">
                            Cari
                        </button>
                        @if(request()->anyFilled(['search', 'period', 'date']))
                            <a href="{{ route('purchase-order.index') }}" class="flex-1 md:flex-none px-5 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium text-center shadow-sm transition-all">
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
                @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm mb-6">
                        <p class="text-red-700 font-medium">{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Data Table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-50/50 text-xs text-gray-500 border-b border-gray-100 uppercase tracking-wider">
                                <tr>
                                    <th class="py-4 px-4 font-medium" style="width: 50px;">No</th>
                                    <th class="py-4 px-4 font-medium">No. PO</th>
                                    <th class="py-4 px-4 font-medium">Tanggal PO</th>
                                    <th class="py-4 px-4 font-medium">Nama Perusahaan</th>
                                    <th class="py-4 px-4 font-medium text-right">Total Harga</th>
                                    <th class="py-4 px-4 font-medium">Dibuat Oleh</th>
                                    <th class="py-4 px-4 font-medium text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($purchaseOrders as $idx => $po)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="py-3 px-4 text-gray-500">{{ $purchaseOrders->firstItem() + $idx }}</td>
                                        <td class="py-3 px-4 font-semibold text-gray-800">{{ $po->no_po }}</td>
                                        <td class="py-3 px-4 text-gray-600">{{ \Carbon\Carbon::parse($po->tanggal_po)->format('d/m/Y') }}</td>
                                        <td class="py-3 px-4 text-gray-800">{{ $po->supplier_name }}</td>
                                        <td class="py-3 px-4 text-right font-medium text-rns-blue">Rp {{ number_format($po->total_harga, 0, ',', '.') }}</td>
                                        <td class="py-3 px-4 text-gray-500">{{ optional($po->user)->name ?? 'Sistem' }}</td>
                                        <td class="py-3 px-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('purchase-order.print', $po->id) }}" target="_blank" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded" title="Cetak PO">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                                </a>
                                                <form action="{{ route('purchase-order.destroy', $po->id) }}" method="POST" id="delete-form-{{ $po->id }}" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="button" onclick="confirmDelete('{{ $po->id }}')" class="p-1.5 text-red-600 hover:bg-red-50 rounded" title="Hapus PO">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-8 text-center text-gray-500">
                                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            Belum ada data Purchase Order
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($purchaseOrders->hasPages())
                    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $purchaseOrders->links('vendor.pagination.custom') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Floating Add Button -->
        <button type="button" onclick="document.getElementById('addModal').classList.remove('hidden'); document.body.classList.add('modal-open');" class="fixed bottom-8 right-8 bg-rns-blue text-white rounded-full p-4 shadow-lg hover:bg-blue-800 transition-all hover:scale-105 z-40 group" title="Buat PO Baru">
            <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        </button>
    </main>

    <!-- Modal Tambah PO - Paper Look -->
    <div id="addModal" class="fixed inset-0 bg-gray-900/60 hidden z-[60] overflow-y-auto backdrop-blur-sm">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-5xl my-8 transform transition-all overflow-hidden flex flex-col border border-gray-200">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-bold text-gray-800">Draft Purchase Order</h3>
                    <button type="button" onclick="closeModal('addModal')" class="text-gray-400 hover:text-gray-600 p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form id="addForm" action="{{ route('purchase-order.store') }}" method="POST" class="flex-1 overflow-y-auto">
                    @csrf
                    <!-- Paper Look Container -->
                    <div class="bg-gray-100 p-4 flex justify-center">
                        <div class="bg-white w-full max-w-[210mm] shadow-lg p-10 text-sm leading-relaxed text-gray-800 border border-gray-200 relative">
                            
                            <!-- Header Section (Top Right Date - Raised) -->
                            <div class="flex justify-end mb-2">
                                <div class="w-48">
                                    <label class="block text-[10px] uppercase tracking-wider text-gray-400 font-bold mb-0 text-right">Banten, Tanggal</label>
                                    <input type="date" name="tanggal_po" value="{{ date('Y-m-d') }}" class="w-full border-b border-gray-300 focus:border-rns-blue outline-none text-right py-0 bg-transparent px-0 font-medium">
                                </div>
                            </div>

                            <div class="text-center font-bold text-xl underline mb-8 uppercase tracking-widest">
                                Purchase Order
                            </div>

                            <!-- Info Section -->
                            <div class="grid grid-cols-2 gap-4 mb-8">
                                <div class="border-2 border-blue-400 p-3 min-h-[100px]">
                                    <input type="text" name="supplier_name" placeholder="Nama Perusahaan (Misal: CV. Sumber Makmur)" required class="w-full font-bold outline-none border-b border-gray-200 focus:border-rns-blue mb-2 bg-transparent text-sm">
                                    <textarea name="supplier_address" rows="3" placeholder="Alamat lengkap..." class="w-full border-b border-gray-100 focus:border-rns-blue outline-none py-1 bg-transparent resize-none text-xs"></textarea>
                                </div>
                                <div class="border-2 border-blue-400 p-3 flex items-center justify-center font-bold text-lg">
                                    No. PO : [Otomatis]
                                </div>
                            </div>

                            <!-- Items Table -->
                            <div class="mb-4">
                                <table class="w-full border-collapse border border-gray-800 text-sm">
                                    <thead class="bg-blue-100">
                                        <tr>
                                            <th class="border border-gray-800 px-2 py-1 w-10 text-center uppercase font-bold text-xs">No</th>
                                            <th class="border border-gray-800 px-2 py-1 text-left uppercase font-bold text-xs">Deskripsi</th>
                                            <th class="border border-gray-800 px-2 py-1 w-24 text-center uppercase font-bold text-xs">Satuan</th>
                                            <th class="border border-gray-800 px-2 py-1 w-24 text-center uppercase font-bold text-xs">Qty</th>
                                            <th class="border border-gray-800 px-2 py-1 w-32 text-center uppercase font-bold text-xs">Harga</th>
                                            <th class="border border-gray-800 px-2 py-1 w-10 text-center"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="add-items-tbody">
                                        <tr class="item-row">
                                            <td class="border border-gray-800 px-2 py-1 text-center align-top pt-2 no-urut">1</td>
                                            <td class="border border-gray-800 px-2 py-1 align-top">
                                                <input type="text" name="items[0][deskripsi]" required class="w-full font-bold outline-none mb-1 border-b border-gray-100 text-sm" placeholder="Nama Barang/Deskripsi">
                                            </td>
                                            <td class="border border-gray-800 px-2 py-1 align-top pt-2">
                                                <input type="text" name="items[0][satuan]" value="Kg" required class="w-full text-center outline-none bg-transparent text-xs border-b border-gray-100">
                                            </td>
                                            <td class="border border-gray-800 px-2 py-1 align-top pt-2">
                                                <input type="number" step="0.01" name="items[0][kuantitas]" value="1" min="0.01" required class="w-full text-center outline-none bg-transparent font-medium border-b border-gray-100 text-sm">
                                            </td>
                                            <td class="border border-gray-800 px-2 py-1 align-top text-right pt-2">
                                                <input type="text" name="items[0][harga_satuan]" oninput="formatRupiahInput(this); calculateTotal();" required class="w-full text-right outline-none bg-transparent font-bold border-b border-gray-100 text-sm" placeholder="0">
                                            </td>
                                            <td class="border border-gray-800 px-1 py-1 text-center align-top pt-2">
                                                <button type="button" class="text-red-300 cursor-not-allowed remove-item" disabled>
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="border border-gray-800 border-l-0 border-b-0 border-t-0"></td>
                                            <td class="border border-gray-800 px-2 py-1 text-right font-bold text-sm bg-gray-50">Total</td>
                                            <td class="border border-gray-800 px-2 py-1 text-right font-bold text-sm bg-gray-50" colspan="2" id="add-total-display">0</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <button type="button" id="add-row-btn" class="mt-1 text-rns-blue text-[10px] font-bold flex items-center gap-1 hover:underline">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    TAMBAH BARIS BARANG
                                </button>
                            </div>

                            <!-- Info Bawah (Catatan) -->
                            <div class="mb-6">
                                <label class="block font-bold text-sm mb-1 text-gray-700">Keterangan Tambahan / Catatan Footer:</label>
                                <textarea name="catatan" rows="6" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-rns-blue focus:border-rns-blue outline-none text-sm bg-yellow-50/30 font-medium">Pembayaran : CASH

Mohon pesanan kami tersebut segera di proses.

Atas perhatian dan kerjasamanya kami ucapkan terima kasih</textarea>
                            </div>

                            <!-- Signature Area -->
                            <div class="flex justify-start pr-4">
                                <div class="w-64 text-left">
                                    <p class="mb-0.5 text-sm">Hormat kami</p>
                                    <p class="font-bold uppercase text-[12px] mb-1">PT. Rand NUSANTARA SEJAHTERA</p>
                                    <div class="h-16 flex items-center justify-start italic text-gray-300 mb-1 text-[10px]">
                                        [Tanda Tangan & Cap]
                                    </div>
                                    <select name="penandatangan" required class="w-full border-b border-gray-200 outline-none font-bold text-left bg-transparent text-sm">
                                        <option value="Dewi Sulistiowati">Dewi Sulistiowati</option>
                                        <option value="Heri Pirdaus, S.Tr.Kes Rad">Heri Pirdaus, S.Tr.Kes Rad</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fixed Footer Buttons -->
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 sticky bottom-0 z-10">
                        <button type="button" onclick="closeModal('addModal')" class="px-6 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 shadow-sm font-medium text-sm transition-colors font-bold tracking-wide">BATAL</button>
                        <button type="submit" class="px-8 py-2 bg-rns-blue text-white rounded-lg hover:bg-blue-800 shadow-lg font-bold text-sm transition-all transform hover:scale-105 flex items-center gap-2 tracking-wide uppercase">
                            Simpan & Cetak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus PO?',
                text: 'Yakin ingin menghapus dokumen PO ini?',
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

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.body.classList.remove('modal-open');
        }

        // Script for Dynamic Rows
        let itemIndex = 1;

        document.getElementById('add-row-btn').addEventListener('click', function() {
            const tbody = document.getElementById('add-items-tbody');
            const rowCount = tbody.children.length;
            
            const tr = document.createElement('tr');
            tr.className = 'item-row';
            tr.innerHTML = `
                <td class="border border-gray-800 px-2 py-1 text-center align-top pt-2 no-urut">${rowCount + 1}</td>
                <td class="border border-gray-800 px-2 py-1 align-top">
                    <input type="text" name="items[${itemIndex}][deskripsi]" required class="w-full font-bold outline-none mb-1 border-b border-gray-100 text-sm" placeholder="Nama Barang/Deskripsi">
                </td>
                <td class="border border-gray-800 px-2 py-1 align-top pt-2">
                    <input type="text" name="items[${itemIndex}][satuan]" value="Kg" required class="w-full text-center outline-none bg-transparent text-xs border-b border-gray-100">
                </td>
                <td class="border border-gray-800 px-2 py-1 align-top pt-2">
                    <input type="number" step="0.01" name="items[${itemIndex}][kuantitas]" value="1" min="0.01" required class="w-full text-center outline-none bg-transparent font-medium border-b border-gray-100 text-sm">
                </td>
                <td class="border border-gray-800 px-2 py-1 align-top text-right pt-2">
                    <input type="text" name="items[${itemIndex}][harga_satuan]" oninput="formatRupiahInput(this); calculateTotal();" required class="w-full text-right outline-none bg-transparent font-bold border-b border-gray-100 text-sm" placeholder="0">
                </td>
                <td class="border border-gray-800 px-1 py-1 text-center align-top pt-2">
                    <button type="button" class="text-red-500 hover:text-red-700 remove-item">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
            
            // Re-bind events
            tr.querySelector('.remove-item').addEventListener('click', function() {
                tr.remove();
                updateRowNumbers();
                calculateTotal();
            });
            
            const inputs = tr.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('input', calculateTotal);
            });
            
            itemIndex++;
            updateRowNumbers();
        });

        function updateRowNumbers() {
            const rows = document.querySelectorAll('#add-items-tbody .item-row');
            rows.forEach((row, index) => {
                row.querySelector('.no-urut').textContent = index + 1;
                
                // Toggle disabled state of first remove button
                const btn = row.querySelector('.remove-item');
                if(index === 0 && rows.length === 1) {
                    btn.disabled = true;
                    btn.classList.add('text-red-300', 'cursor-not-allowed');
                    btn.classList.remove('text-red-500', 'hover:text-red-700');
                } else {
                    btn.disabled = false;
                    btn.classList.remove('text-red-300', 'cursor-not-allowed');
                    btn.classList.add('text-red-500', 'hover:text-red-700');
                }
            });
        }

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(number);
        }

        function formatRupiahInput(input) {
            let value = input.value.replace(/[^,\d]/g, '').toString();
            let split = value.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            input.value = rupiah;
        }

        function calculateTotal() {
            let total = 0;
            const rows = document.querySelectorAll('#add-items-tbody .item-row');
            
            rows.forEach(row => {
                const qtyInput = row.querySelector('input[name*="[kuantitas]"]');
                const priceInput = row.querySelector('input[name*="[harga_satuan]"]');
                
                const qty = parseFloat(qtyInput ? qtyInput.value : 0) || 0;
                // Parse float after removing dots
                const priceStr = priceInput ? priceInput.value.replace(/\./g, '') : '0';
                const price = parseFloat(priceStr) || 0;
                
                total += (qty * price);
            });
            
            document.getElementById('add-total-display').textContent = formatRupiah(total).replace('Rp', '').trim();
        }

        // Bind calculation to existing inputs
        document.querySelectorAll('#add-items-tbody input').forEach(input => {
            input.addEventListener('input', calculateTotal);
        });
    </script>
</body>
</html>
