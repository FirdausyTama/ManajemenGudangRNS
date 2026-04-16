@php
    $barangsJson = $barangs->mapWithKeys(function ($item) {
        return [$item->id => [
            'name' => $item->name,
            'unit' => $item->unit,
            'price' => $item->selling_price,
            'spec' => $item->factory . ' ' . $item->merek
        ]];
    })->toJson();
@endphp

<script>
    const barangData = {!! $barangsJson !!};
    
    function updateItemData(selectElement) {
        const row = $(selectElement).closest('tr');
        const barangId = $(selectElement).val();
        
        if (barangId && barangData[barangId]) {
            const data = barangData[barangId];
            row.find('input[name*="[nama_barang]"]').val(data.name);
            row.find('textarea[name*="[spesifikasi]"]').val(data.spec);
            row.find('input[name*="[satuan]"]').val(data.unit);
            row.find('input[name*="[harga_satuan]"]').val(data.price);
            
            // Auto update intro text if it's the first item
            if (row.is(':first-child')) {
                const instansi = $('input[name="nama_customer"]').val() || '[Nama Instansi]';
                const product = data.name;
                const introTemplate = `Dengan Hormt,\nPerihal Penawaran Harga, Bersama ini kami sampaikan penawaran harga **${product}** di ${instansi} sebagai berikut :`;
                $('textarea[name="salam_pembuka"]').val(introTemplate);
            }
        } else {
            // If manual input is selected, clear barang_id
            row.find('input[name*="[barang_id]"], select[name*="[barang_id]"]').val('');
        }
    }
</script>

<!-- Modal Tambah SPH -->
<div id="addModal" class="fixed inset-0 bg-gray-900/60 hidden z-[60] overflow-y-auto backdrop-blur-sm">
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-5xl my-8 transform transition-all overflow-hidden flex flex-col border border-gray-200">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-lg font-bold text-gray-800">Draft Surat Penawaran Harga</h3>
                <button type="button" onclick="closeModal('addModal')" class="text-gray-400 hover:text-gray-600 p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form id="addForm" action="{{ route('surat-penawaran.store') }}" method="POST" enctype="multipart/form-data" class="flex-1 overflow-y-auto">
                @csrf
                <!-- Paper Look Container -->
                <div class="bg-gray-100 p-4 flex justify-center">
                    <div class="bg-white w-full max-w-[210mm] shadow-lg p-10 text-sm leading-relaxed text-gray-800 border border-gray-200 relative">
                        
                        <!-- Header Section (Top Right Date - Raised) -->
                        <div class="flex justify-end mb-2">
                            <div class="w-48">
                                <label class="block text-[10px] uppercase tracking-wider text-gray-400 font-bold mb-0 text-right">Serang, Tanggal</label>
                                <input type="date" name="tanggal_sph" value="{{ date('Y-m-d') }}" class="w-full border-b border-gray-300 focus:border-rns-blue outline-none text-right py-0 bg-transparent px-0 font-medium">
                            </div>
                        </div>

                        <!-- Info Section (Left: No, Hal) -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="space-y-0">
                                <div class="flex items-start">
                                    <span class="w-16 font-semibold">No.</span>
                                    <span class="mr-2">:</span>
                                    <span class="text-gray-500 italic">[Otomatis]</span>
                                </div>
                                <div class="flex items-start">
                                    <span class="w-16 font-semibold">Hal.</span>
                                    <span class="mr-2">:</span>
                                    <input type="text" name="perihal" value="Penawaran Harga" required class="flex-1 border-b border-gray-200 focus:border-rns-blue outline-none py-0 font-bold underline bg-transparent">
                                </div>
                            </div>
                        </div>

                        <!-- Recipient Section -->
                        <div class="mb-6 space-y-0">
                            <p class="font-bold flex items-center gap-2">Kepada. Yth</p>
                            <input type="text" name="jabatan_customer" placeholder="Direktur" class="w-full border-b border-gray-200 focus:border-rns-blue outline-none py-0 font-bold bg-transparent">
                            <input type="text" name="nama_customer" placeholder="Nama Instansi (e.g. RS Permata Kuningan)" required class="w-full border-b border-gray-200 focus:border-rns-blue outline-none py-0 font-bold bg-transparent">
                            <textarea name="alamat_customer" rows="2" placeholder="Alamat lengkap..." class="w-full border-b border-gray-100 focus:border-rns-blue outline-none py-1 bg-transparent resize-none text-xs"></textarea>
                            <input type="hidden" name="no_hp_customer" value="">
                        </div>

                        <!-- Intro Text -->
                        <div class="mb-4">
                            <textarea name="salam_pembuka" rows="3" class="w-full border border-dashed border-gray-200 p-2 rounded focus:border-rns-blue outline-none bg-blue-50/20 text-sm leading-relaxed">Dengan Hormt,&#10;Perihal Penawaran Harga, Bersama ini kami sampaikan penawaran harga produk di instansi Bapak/Ibu sebagai berikut :</textarea>
                        </div>

                        <!-- Items Table -->
                        <div class="mb-4">
                            <table class="w-full border-collapse border border-gray-800 text-sm">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border border-gray-800 px-2 py-1 w-10 text-center uppercase font-bold text-xs">No</th>
                                        <th class="border border-gray-800 px-2 py-1 text-left uppercase font-bold text-xs">Nama Barang</th>
                                        <th class="border border-gray-800 px-2 py-1 w-24 text-center uppercase font-bold text-xs">Qty</th>
                                        <th class="border border-gray-800 px-2 py-1 w-40 text-center uppercase font-bold text-xs">Harga</th>
                                        <th class="border border-gray-800 px-2 py-1 w-10 text-center"></th>
                                    </tr>
                                </thead>
                                <tbody id="add-items-tbody">
                                    <tr class="item-row">
                                        <td class="border border-gray-800 px-2 py-1 text-center align-top pt-2">1</td>
                                        <td class="border border-gray-800 px-2 py-1 align-top">
                                            <!-- Product Select From Stock -->
                                            <select name="items[0][barang_id]" onchange="updateItemData(this)" class="w-full border border-blue-200 rounded px-2 py-0.5 mb-1 text-xs focus:ring-1 focus:ring-rns-blue outline-none bg-blue-50/50">
                                                <option value="">-- Pilih dari Stok --</option>
                                                @foreach($barangs as $b)
                                                    <option value="{{ $b->id }}">{{ $b->name }} ({{ $b->factory }})</option>
                                                @endforeach
                                                <option value="">-- Input Manual --</option>
                                            </select>
                                            <input type="text" name="items[0][nama_barang]" required class="w-full font-bold outline-none mb-1 border-b border-gray-100 text-sm" placeholder="Nama Barang">
                                            <textarea name="items[0][spesifikasi]" rows="2" class="w-full text-xs text-gray-600 outline-none bg-transparent resize-none border-b border-gray-50 mb-1" placeholder="Spesifikasi detail..."></textarea>
                                            <div class="mt-1">
                                                <label class="block text-[9px] uppercase font-bold text-gray-400 mb-0.5">Upload Foto Produk (Opsional)</label>
                                                <input type="file" name="items[0][images][]" multiple accept="image/*" class="w-full text-[10px] text-gray-500 file:mr-2 file:py-0.5 file:px-2 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                            </div>
                                        </td>
                                        <td class="border border-gray-800 px-2 py-1 align-top pt-2">
                                            <div class="flex items-center gap-1">
                                                <input type="number" name="items[0][kuantitas]" value="1" step="0.01" required class="w-full text-center outline-none bg-transparent font-medium border-b border-gray-100 text-sm">
                                                <input type="text" name="items[0][satuan]" value="Unit" required class="w-12 text-center outline-none bg-transparent text-xs border-b border-gray-100">
                                            </div>
                                        </td>
                                        <td class="border border-gray-800 px-2 py-1 align-top text-right pt-2">
                                            <input type="number" name="items[0][harga_satuan]" required class="w-full text-right outline-none bg-transparent font-bold border-b border-gray-100 text-sm" placeholder="0">
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
                                        <td colspan="3" class="border border-gray-800 px-2 py-1 text-right font-bold uppercase text-xs">Total harga</td>
                                        <td class="border border-gray-800 px-2 py-1 text-right font-bold text-base" id="add-total-display">0</td>
                                        <td class="border border-gray-800"></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <button type="button" id="add-row-btn" class="mt-1 text-rns-blue text-[10px] font-bold flex items-center gap-1 hover:underline">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                TAMBAH BARIS BARANG
                            </button>
                        </div>

                        <!-- Terbilang Under Table -->
                        <div class="text-right italic mb-4 text-xs" id="add-terbilang-display">
                            [Terbilang Rupiah]
                        </div>

                        <!-- Sections: Catatan, Cara Pembayaran -->
                        <div class="grid grid-cols-1 gap-4 mb-6">
                            <div>
                                <h4 class="font-bold underline mb-0.5 text-xs">Catatan:</h4>
                                <textarea name="syarat_ketentuan" rows="4" class="w-full border-0 focus:ring-0 outline-none bg-yellow-50/30 p-2 text-[11px] leading-tight border-l-2 border-yellow-200">
- Kondisi alat second layak pakai dan masih sangat bagus.&#10;- Harga sudah termasuk ongkir, Instal, Uji Fungsi, Uji Kesesuaian, Uji Paparan Ruangan dan Perijinan&#10;- Garansi service X-Ray 3 Bulan, Garansi tidak berlaku, jika terjadi keadaan memaksa (force majeure), yaitu keadaan di luar kemampuan seperti bencana alam, konsleting listrik, banjir, kebakaran, mobilisasi, pemogokan, blokade, revolusi, huru hara, sabotase
                                </textarea>
                            </div>
                            <div>
                                <h4 class="font-bold underline mb-0.5 text-xs">Cara pembayaran:</h4>
                                <textarea name="keterangan_pembayaran" rows="5" class="w-full border-0 focus:ring-0 outline-none bg-blue-50/20 p-2 text-[11px] leading-tight border-l-2 border-blue-200">
Pembayaran Pertama DP 50% Setelah PO atau SPK kami terima&#10;Pembayaran Ke Dua 50% Setelah Alat terinstal dengan baik Pelunasan.&#10;&#10;Pembayaran Bisa Di Tranfer Melalui **Rek Bank BSI (BANK SYARIAH INDONESIA) :&#10;No Rek : 1101198975&#10;Atas Nama : PT RANAY NUSANTARA SEJAHTERA&#10;Kode bank : 451**
                                </textarea>
                            </div>
                        </div>

                        <!-- Closing -->
                        <div class="mb-6">
                            <textarea name="salam_penutup" rows="3" class="w-full border-0 focus:ring-0 outline-none text-xs leading-relaxed bg-transparent">Demikian surat penawaran ini kami buat, apabila ada informasi yang perlu diketahui lebih lanjut mengenai penawaran ini, maka dapat menghubungi kami (**Bpk Heri Pirdaus : 085273435980**).&#10;Atas perhatianya dan kerjasamanya kami ucapkan terimakasih.</textarea>
                        </div>

                        <!-- Signature Area -->
                        <div class="flex justify-end pr-4">
                            <div class="w-64 text-center">
                                <p class="mb-0.5 text-xs">Hormat kami</p>
                                <p class="font-bold uppercase text-[10px] mb-1">PT. RANAY NUSANTARA SEJAHTERA</p>
                                <div class="h-16 flex items-center justify-center italic text-gray-300 border border-dashed border-gray-100 mb-1 text-[10px]">
                                    [Tanda Tangan]
                                </div>
                                <select name="penandatangan" required class="w-full border-b border-gray-200 outline-none font-bold text-center bg-transparent text-xs">
                                    <option value="Heri Pirdaus, S.Tr.Kes Rad">Heri Pirdaus, S.Tr.Kes Rad</option>
                                    <option value="Dewi Sulistiowati">Dewi Sulistiowati</option>
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

</script>
