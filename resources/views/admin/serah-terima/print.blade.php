<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SERAH_TERIMA_{{ $surat->kepada }}_{{ \Carbon\Carbon::parse($surat->tanggal)->format('d_m_Y') }}</title>
    <style>
        @page { margin: 0; size: A4; }
        body { font-family: 'Times New Roman', Times, serif; color: #000; line-height: 1.5; margin: 0; padding: 0; font-size: 14px; }
        .container { width: 210mm; min-height: 297mm; margin: 0 auto; position: relative; box-sizing: border-box; padding: 10mm 15mm; }
        
        .header { text-align: center; padding-bottom: 5px; margin-bottom: 20px; border-bottom: 3px solid #000; }
        .logo-kopsurat { width: 100%; max-width: 800px; height: auto; }
        
        .tanggal-box { text-align: right; margin-bottom: 20px; }
        
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { vertical-align: top; padding: 3px 0; }
        .info-table td:first-child { width: 150px; font-weight: bold; }
        .info-table td:nth-child(2) { width: 10px; text-align: center; }
        
        .title { text-align: center; font-size: 18px; font-weight: bold; text-transform: uppercase; margin: 30px 0 20px 0; letter-spacing: 1px; }
        
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 8px; }
        table.data-table th { background-color: #92bce6; color: #000; font-weight: bold; text-align: center; }
        table.data-table th.left, table.data-table td.left { text-align: left; }
        table.data-table th.center, table.data-table td.center { text-align: center; }
        
        .signatures { display: flex; justify-content: space-between; margin-top: 50px; padding: 0 20px; }
        .sig-box { width: 40%; text-align: center; position: relative; }
        .sig-title { margin-bottom: 80px; }
        .sig-name { font-weight: bold; text-decoration: underline; }
        
        .ttd-image { position: absolute; top: 10px; left: 50%; transform: translateX(-50%); max-width: 150px; height: auto; z-index: -1; }
        
        .footer-image-container { position: absolute; bottom: 0; left: 0; width: 100%; text-align: center; line-height: 0; }
        .footer-image { width: 100%; height: auto; display: block; }

        .watermark { position: absolute; top: 0; left: 0; width: 100%; height: 100%; box-sizing: border-box; object-fit: contain; opacity: 0.1; z-index: -1; pointer-events: none; }

        .btn-floating-print, .btn-back { display: flex; position: fixed; z-index: 1000; cursor: pointer; align-items: center; justify-content: center; }
        .btn-floating-print { bottom: 30px; right: 30px; background-color: #1e3a8a; color: white; width: 60px; height: 60px; border-radius: 50%; box-shadow: 0 4px 10px rgba(0,0,0,0.3); border: none; transition: transform 0.2s; }
        .btn-floating-print:hover { transform: scale(1.05); }
        .btn-floating-print svg { width: 25px; height: 25px; fill: currentColor; }
        .btn-back { top: 20px; left: 20px; background-color: white; color: #1e3a8a; padding: 10px 20px; border-radius: 10px; gap: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); border: 1px solid #e2e8f0; text-decoration: none; font-weight: 600; }
        
        @media print {
            .btn-floating-print, .btn-back { display: none !important; }
            .container { padding: 5mm 15mm; width: 100%; background: none; }
            .watermark { display: block !important; }
        }
    </style>
</head>
<body>
    <button onclick="window.close(); window.history.back();" class="btn-back" title="Kembali / Tutup Halaman">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/></svg>
        <span>Kembali / Tutup</span>
    </button>
    <button onclick="window.print()" class="btn-floating-print" title="Cetak Surat Serah Terima">
        <svg viewBox="0 0 24 24"><path d="M19 8H5V3H19V8ZM16 5H8V6H16V5ZM22 13.5C22 14.33 21.33 15 20.5 15C19.67 15 19 14.33 19 13.5C19 12.67 19.67 12 20.5 12C21.33 12 22 12.67 22 13.5ZM18 19H6V15H18V19ZM19 22H5V17H2.99C1.89 17 1 16.1 1 15V11C1 9.34 2.34 8 4 8H20C21.66 8 23 9.34 23 11V15C23 16.1 22.11 17 21.01 17H19V22Z"/></svg>
    </button>

    <div class="container">
        <img src="{{ asset('assets/images/logo-rns-bg.png') }}" class="watermark" alt="Watermark">
        
        <div class="header" style="border-bottom: none; padding-bottom: 0;">
            <img src="{{ asset('assets/images/kopsurat.png') }}" alt="Kop Surat RNS" class="logo-kopsurat">
        </div>
        <!-- Removed Black bar under header -->

        <div class="tanggal-box">
            Banten, {{ \Carbon\Carbon::parse($surat->tanggal)->translatedFormat('d F Y') }}
        </div>

        <table class="info-table">
            <tr>
                <td>KEPADA YTH</td>
                <td>:</td>
                <td>{{ strtoupper($surat->kepada) }}</td>
            </tr>
            <tr>
                <td>ALAMAT</td>
                <td>:</td>
                <td>{{ $surat->alamat }}</td>
            </tr>
            <tr>
                <td>KETERANGAN</td>
                <td>:</td>
                <td>{{ $surat->keterangan }}</td>
            </tr>
        </table>

        <div class="title">SERAH TERIMA BARANG</div>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 40px;">NO</th>
                    <th class="left">NAMA BARANG</th>
                    <th style="width: 100px;">QTY</th>
                    <th style="width: 150px;">JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $items = is_string($surat->items) ? json_decode($surat->items, true) : $surat->items;
                @endphp
                @if($items && is_array($items))
                    @foreach($items as $index => $item)
                    <tr>
                        <td class="center">{{ $index + 1 }}.</td>
                        <td>{{ $item['nama_barang'] ?? '' }}</td>
                        <td class="center">{{ $item['qty'] ?? '' }}</td>
                        <td class="center">{{ $item['jumlah'] ?? '' }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="center">1.</td>
                        <td>{{ $surat->nama_barang }}</td>
                        <td class="center">{{ $surat->qty }}</td>
                        <td class="center">{{ $surat->jumlah }}</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="signatures">
            <div class="sig-box">
                <div class="sig-title">COSTUMER / PIHAK RS</div>
                <div class="sig-name">{{ strtoupper($surat->kepada) }}</div>
            </div>
            
            <div class="sig-box">
                <div class="sig-title">PENGIRIM</div>
                @if($surat->pengirim == 'Dewi Sulistiowati')
                    <img src="{{ asset('assets/images/ttdDewi.png') }}" class="ttd-image" alt="Tanda Tangan Dewi">
                @elseif($surat->pengirim == 'Heri Pirdaus, S.Tr.Kes Rad (MRI)')
                    <img src="{{ asset('assets/images/ttdHeri.png') }}" class="ttd-image" alt="Tanda Tangan Heri">
                @endif
                <div class="sig-name">{{ strtoupper($surat->pengirim) }}</div>
            </div>
        </div>

        <div class="footer-image-container">
            <img src="{{ asset('assets/images/footerrns.png') }}" alt="Footer RNS" class="footer-image">
        </div>
    </div>
</body>
</html>
