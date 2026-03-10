<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $penjualan->no_transaksi }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            background: #fff;
            font-size: 14px;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo-kopsurat {
            width: 100%;
            max-width: 800px;
            height: auto;
        }

        .invoice-title {
            text-align: right;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .invoice-title h2 {
            font-size: 32px;
            margin: 0;
            color: #1e3a8a;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .invoice-title p {
            margin: 5px 0 0 0;
            font-size: 14px;
            font-weight: 500;
            color: #666;
        }

        .details-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .bill-to h3, .invoice-details h3 {
            font-size: 13px;
            text-transform: uppercase;
            color: #888;
            margin: 0 0 10px 0;
            letter-spacing: 1px;
        }

        .bill-to p, .invoice-details p {
            margin: 0 0 5px 0;
            line-height: 1.5;
        }

        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-details table td {
            padding: 3px 0;
        }

        .invoice-details table td:last-child {
            text-align: right;
            font-weight: 600;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table th {
            background-color: #f8fafc;
            color: #1e3a8a;
            font-weight: 600;
            text-align: left;
            padding: 12px;
            border-bottom: 2px solid #e2e8f0;
            text-transform: uppercase;
            font-size: 12px;
        }

        .items-table th.right, .items-table td.right {
            text-align: right;
        }

        .items-table th.center, .items-table td.center {
            text-align: center;
        }

        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            color: #444;
        }

        .totals-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 50px;
        }

        .totals-table {
            width: 350px;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 8px 12px;
        }

        .totals-table td.right {
            text-align: right;
        }

        .totals-table tr.total th, .totals-table tr.total td {
            background-color: #f8fafc;
            color: #1e3a8a;
            font-size: 18px;
            font-weight: 700;
            padding: 15px 12px;
            border-top: 2px solid #1e3a8a;
            border-bottom: 2px solid #1e3a8a;
        }
        
        .totals-table tr.total th {
            text-align: left;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 60px;
        }

        .signature {
            text-align: center;
            width: 250px;
        }

        .signature .img-ttd {
            height: 80px;
            object-fit: contain;
            margin: 15px 0 5px 0;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .signature p.name {
            font-weight: 700;
            margin-top: 5px;
            text-decoration: underline;
        }

        .status-badge {
            display: none;
        }

        .btn-floating-print {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #1e3a8a;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            cursor: pointer;
            border: none;
            z-index: 1000;
            transition: transform 0.2s, background-color 0.2s;
        }

        .btn-floating-print:hover {
            background-color: #152c6b;
            transform: scale(1.05);
        }

        .btn-floating-print svg {
            width: 25px;
            height: 25px;
            fill: currentColor;
        }

        @media print {
            body { font-size: 12px; }
            .invoice-container { padding: 0; max-width: 100%; }
            .btn-floating-print { display: none !important; }
        }
    </style>
</head>
<body onload="window.print()">

    <button onclick="window.print()" class="btn-floating-print" title="Cetak Invoice">
        <svg viewBox="0 0 24 24"><path d="M19 8H5V3H19V8ZM16 5H8V6H16V5ZM22 13.5C22 14.33 21.33 15 20.5 15C19.67 15 19 14.33 19 13.5C19 12.67 19.67 12 20.5 12C21.33 12 22 12.67 22 13.5ZM18 19H6V15H18V19ZM19 22H5V17H2.99C1.89 17 1 16.1 1 15V11C1 9.34 2.34 8 4 8H20C21.66 8 23 9.34 23 11V15C23 16.1 22.11 17 21.01 17H19V22Z"/></svg>
    </button>

    <div class="invoice-container">
        
        <div class="header">
            <img src="{{ asset('assets/images/kopsurat.png') }}" alt="Kop Surat RNS" class="logo-kopsurat" onerror="this.src=''">
        </div>
        
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 20px;">
            <div></div> <!-- Spacer -->
            <div class="invoice-title">
                <h2>INVOICE</h2>
                <p># {{ $penjualan->no_transaksi }}</p>
            </div>
        </div>

        <div class="details-section">
            <div class="bill-to">
                <h3>Tagihan Kepada:</h3>
                <p style="font-weight: 700; font-size: 15px; color: #1e3a8a;">{{ $penjualan->nama_customer }}</p>
                <p>{{ $penjualan->alamat_customer ?? '-' }}</p>
                <p>Telp: {{ $penjualan->no_hp_customer ?? '-' }}</p>
            </div>
            <div class="invoice-details">
                <h3>Detail Transaksi:</h3>
                <table>
                    <tr>
                        <td>No. Invoice:</td>
                        <td>{{ $penjualan->no_transaksi }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Tagihan:</td>
                        <td>{{ $penjualan->tanggal_transaksi->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td>Dikeluarkan Oleh:</td>
                        <td>{{ collect(explode(' ', $penjualan->user->name ?? 'System'))->first() }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 5%">NO</th>
                    <th style="width: 45%">DESKRIPSI BARANG</th>
                    <th class="center" style="width: 10%">QTY</th>
                    <th class="right" style="width: 20%">HARGA SATUAN</th>
                    <th class="right" style="width: 20%">JUMLAH (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualan->items as $idx => $item)
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td style="font-weight: 500;">{{ $item->barang->name ?? 'Barang Terhapus' }}</td>
                    <td class="center">{{ $item->kuantitas }}</td>
                    <td class="right">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td class="right" style="font-weight: 600;">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals-section">
            <table class="totals-table">
                @if($penjualan->is_ongkir_aktif)
                <tr>
                    <td>Subtotal Barang</td>
                    <td class="right">Rp {{ number_format($penjualan->total_keseluruhan - $penjualan->total_ongkir, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Ongkos Kirim ({{ $penjualan->berat_total }} kg)</td>
                    <td class="right">Rp {{ number_format($penjualan->total_ongkir, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr class="total">
                    <th>TOTAL TAGIHAN</th>
                    <td class="right">Rp {{ number_format($penjualan->total_keseluruhan, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <div class="notes">
                <h4 style="margin:0 0 5px 0; color:#1e3a8a;">Keterangan / Catatan:</h4>
                <p style="margin:0; font-size:12px; color:#666; width: 350px; line-height:1.5;">
                    Mohon lakukan pembayaran sesuai tagihan ke rekening berikut:<br>
                    <strong>Bank Nasional - 123456789 (PT Ranay Nusantara Sejahtera)</strong><br>
                    Terima kasih atas kerja sama dan kepercayaan Anda.
                </p>
            </div>
            <div class="signature">
                <p style="margin:0 0 10px 0; color:#333; font-size:12px;">Serang, {{ $penjualan->tanggal_transaksi->translatedFormat('d F Y') }}</p>
                <p style="margin:0; color:#666; font-size:12px;">Hormat Kami,</p>
                <p style="margin:5px 0 0 0; font-weight:600; color:#1e3a8a; font-size:13px;">PT Ranay Nusantara Sejahtera</p>
                
                @if(isset($penandatangan) && trim($penandatangan) == 'Dewi Sulistiowati')
                    <img src="{{ asset('assets/images/ttdDewi.png') }}" alt="Tanda Tangan Dewi" class="img-ttd">
                @elseif(isset($penandatangan) && str_contains($penandatangan, 'Heri Pirdaus'))
                    <img src="{{ asset('assets/images/ttdHeri.png') }}" alt="Tanda Tangan Heri" class="img-ttd">
                @else
                    <div style="height: 100px;"></div>
                @endif
                
                <p class="name">{{ $penandatangan ?? 'Admin RNS' }}</p>
            </div>
        </div>

    </div>

</body>
</html>
