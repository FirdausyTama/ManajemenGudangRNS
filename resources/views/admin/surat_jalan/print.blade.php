<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SURAT_JALAN_{{ $surat_jalan->nama_penerima }}_{{ \Carbon\Carbon::parse($surat_jalan->tanggal_surat_jalan)->format('d_m_Y') }}</title>
    <style>
        @page {
            margin: 0;
            size: A4;
        }
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            font-size: 13px;
        }
        .container {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            position: relative;
            box-sizing: border-box;
            padding: 10mm 15mm;
        }
        .header {
            text-align: center;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .logo-kopsurat {
            width: 100%;
            max-width: 800px;
            height: auto;
        }
        .title-box {
            text-align: center;
            margin-bottom: 25px;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-decoration: underline;
        }
        .nomor {
            font-size: 14px;
            margin-top: 5px;
        }
        
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
        }
        .info-box {
            width: 100%;
        }
        .info-box h4 {
            margin: 0 0 10px 0;
            color: #1e3a8a;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        table.data-table th {
            background-color: #f8fafc;
            color: #333;
            font-weight: bold;
            text-align: left;
        }
        table.data-table th.center, table.data-table td.center {
            text-align: center;
        }
        table.data-table th.right, table.data-table td.right {
            text-align: right;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }
        .sig-box {
            width: 30%;
            text-align: center;
        }
        .sig-title {
            margin-bottom: 60px;
        }
        .sig-name {
            font-weight: bold;
            text-decoration: underline;
        }

        .footer-image-container {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            line-height: 0;
        }
        .footer-image {
            width: 100%;
            height: auto;
            display: block;
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

        .btn-back {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: white;
            color: #1e3a8a;
            padding: 10px 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            cursor: pointer;
            border: 1px solid #e2e8f0;
            z-index: 9999; /* Ensure it's on top of everything */
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s;
            pointer-events: auto !important; /* Force clickability */
        }

        .btn-back:hover {
            background-color: #f8fafc;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            color: #1e3a8a;
        }

        @media print {
            .btn-floating-print, .btn-back {
                display: none !important;
            }
            .container {
                padding: 5mm 15mm;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <button onclick="window.close(); window.history.back();" class="btn-back" title="Kembali / Tutup Halaman">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
        </svg>
        <span>Kembali / Tutup</span>
    </button>

    <button onclick="window.print()" class="btn-floating-print" title="Cetak Surat Jalan">
        <svg viewBox="0 0 24 24"><path d="M19 8H5V3H19V8ZM16 5H8V6H16V5ZM22 13.5C22 14.33 21.33 15 20.5 15C19.67 15 19 14.33 19 13.5C19 12.67 19.67 12 20.5 12C21.33 12 22 12.67 22 13.5ZM18 19H6V15H18V19ZM19 22H5V17H2.99C1.89 17 1 16.1 1 15V11C1 9.34 2.34 8 4 8H20C21.66 8 23 9.34 23 11V15C23 16.1 22.11 17 21.01 17H19V22Z"/></svg>
    </button>

    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/images/kopsurat.png') }}" alt="Kop Surat RNS" class="logo-kopsurat" onerror="this.src=''">
        </div>

        <div class="title-box">
            <div class="title">Surat Jalan</div>
            <div class="nomor">No: {{ $surat_jalan->nomor_surat_jalan }}</div>
        </div>

        <div class="info-section">
            <div class="info-box">
                <h4>PENERIMA</h4>
                <div style="font-weight: bold;">{{ strtoupper($surat_jalan->nama_penerima) }}</div>
                <div>{{ $surat_jalan->alamat_penerima }}</div>
                <div>Telp: {{ $surat_jalan->telp_penerima }}</div>
            </div>
        </div>

        <div style="margin-bottom: 10px;">
            <strong>Tanggal Pengiriman:</strong> {{ \Carbon\Carbon::parse($surat_jalan->tanggal_surat_jalan)->translatedFormat('d F Y') }}
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th class="center" style="width: 50px;">No</th>
                    <th>Nama Barang / Jasa</th>
                    <th class="center" style="width: 100px;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @if($surat_jalan->penjualan && $surat_jalan->penjualan->items->count() > 0)
                    @foreach($surat_jalan->penjualan->items as $idx => $item)
                        <tr>
                            <td class="center">{{ $idx + 1 }}</td>
                            <td>
                                <strong>{{ $item->barang ? $item->barang->name : 'Barang' }}</strong>
                                @if($idx == 0 && $surat_jalan->keterangan && $surat_jalan->keterangan !== '-')
                                    <div style="font-size: 12px; color: #666; margin-top: 5px;">Catatan SJ: {{ $surat_jalan->keterangan }}</div>
                                @endif
                            </td>
                            <td class="center">{{ $item->kuantitas }} {{ $item->barang ? $item->barang->unit : '' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="center">1</td>
                        <td>
                            <strong>{{ $surat_jalan->nama_barang_jasa }}</strong>
                            @if($surat_jalan->keterangan && $surat_jalan->keterangan !== '-')
                                <div style="font-size: 12px; color: #666; margin-top: 5px;">Catatan: {{ $surat_jalan->keterangan }}</div>
                            @endif
                        </td>
                        <td class="center">{{ $surat_jalan->qty }}</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div style="margin-top: 40px; font-size: 12px; font-style: italic; color: #555;">
            * Mohon periksa kembali kondisi barang saat diterima.<br>
            * Surat jalan ini juga berlaku sebagai bukti serah terima barang/jasa yang sah.
        </div>

        <div class="signatures">
            <div class="sig-box">
                <div class="sig-title">Penerima Barang / Instansi</div>
                <div class="sig-name">( &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )</div>
                <div style="font-size: 11px; margin-top: 5px;">Tanda tangan & Nama Jelas</div>
            </div>
            
            <div class="sig-box">
                <div class="sig-title">Pengirim / Ekspedisi</div>
                <div class="sig-name">( &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )</div>
                <div style="font-size: 11px; margin-top: 5px;">Tanda tangan & Nama Jelas</div>
            </div>
            
            <div class="sig-box">
                <div class="sig-title">Hormat Kami,</div>
                <div class="sig-name">( &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )</div>
                <div style="font-size: 11px; margin-top: 5px;">Tanda tangan & Nama Jelas</div>
            </div>
        </div>

        <div class="footer-image-container">
            <img src="{{ asset('assets/images/footerrns.png') }}" alt="Footer RNS" class="footer-image">
        </div>
    </div>
</body>
</html>
