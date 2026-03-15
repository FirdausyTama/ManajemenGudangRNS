<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>SPH - {{ $surat_penawaran->no_sph }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');
        
        @page {
            margin: 0;
            size: A4;
        }

        @media print {
            .page-break {
                page-break-after: always;
                break-after: page;
            }
        }

        body {
            font-family: 'Roboto', sans-serif;
            color: #000;
            margin: 0;
            padding: 0;
            background: #fff;
            font-size: 13px;
            line-height: 1.3;
        }

        .container {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 10mm 15mm;
            box-sizing: border-box;
            position: relative;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo-kopsurat {
            width: 100%;
            height: auto;
        }

        .document-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            align-items: flex-start;
        }

        .info-left table {
            border-collapse: collapse;
            margin-top: 20px; /* Offset to make date look higher */
        }

        .info-left td {
            padding: 0;
            vertical-align: top;
        }

        .info-right {
            text-align: right;
            margin-top: 0;
        }

        .recipient {
            margin-bottom: 20px;
        }

        .recipient p {
            margin: 0;
            font-weight: 700;
        }

        .recipient .address {
            font-weight: 700;
            margin-top: 2px;
            max-width: 450px;
            font-size: 11px;
        }

        .footer-image-container {
            position: absolute;
            bottom: 0mm;
            left: 0;
            width: 100%;
            text-align: center;
        }

        .footer-image {
            width: 100%;
            height: auto;
        }

        .intro {
            margin-bottom: 15px;
            text-align: justify;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }

        .items-table th {
            font-weight: 700;
            text-align: center;
            padding: 4px;
            border: 1px solid #000;
            background-color: #f9f9f9;
        }

        .items-table td {
            padding: 4px 6px;
            border: 1px solid #000;
            vertical-align: top;
        }

        .item-spec {
            font-size: 11px;
            margin-top: 2px;
            white-space: pre-line;
            font-weight: 400;
        }

        .terbilang-row {
            text-align: right;
            font-style: italic;
            margin-top: 2px;
            font-size: 12px;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: 700; }

        .image-gallery {
            margin-top: 20px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .gallery-item {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            background: #fdfdfd;
        }

        .gallery-img {
            max-width: 100%;
            max-height: 250px;
            object-fit: contain;
            display: block;
            margin: 0 auto 8px;
        }

        .gallery-caption {
            font-size: 11px;
            font-weight: 700;
            color: #333;
            text-transform: uppercase;
        }

        .section-title {
            font-weight: 700;
            text-decoration: underline;
            margin-bottom: 2px;
            font-size: 12px;
        }

        .info-content {
            white-space: pre-line;
            font-size: 11px;
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .closing {
            margin-top: 10px;
            margin-bottom: 20px;
            text-align: justify;
            font-size: 12px;
        }

        .footer {
            display: flex;
            justify-content: flex-end;
        }

        .signature {
            text-align: center;
            width: 250px;
        }

        .signature .img-ttd {
            height: 60px;
            object-fit: contain;
            margin: 2px auto;
            display: block;
        }

        .signature p.name {
            font-weight: 700;
            margin-top: 0;
            text-decoration: underline;
        }

        .btn-floating-print {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #1e3a8a;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            cursor: pointer;
            border: none;
            z-index: 1000;
        }

        @media print {
            .btn-floating-print { display: none !important; }
            .container { padding: 5mm 15mm; width: 100%; }
        }
    </style>
</head>
<body onload="window.print()">

    <button onclick="window.print()" class="btn-floating-print" title="Cetak SPH">
        <svg viewBox="0 0 24 24" style="width:24px; height:24px; fill:currentColor;"><path d="M19 8H5V3H19V8ZM16 5H8V6H16V5ZM22 13.5C22 14.33 21.33 15 20.5 15C19.67 15 19 14.33 19 13.5C19 12.67 19.67 12 20.5 12C21.33 12 22 12.67 22 13.5ZM18 19H6V15H18V19ZM19 22H5V17H2.99C1.89 17 1 16.1 1 15V11C1 9.34 2.34 8 4 8H20C21.66 8 23 9.34 23 11V15C23 16.1 22.11 17 21.01 17H19V22Z"/></svg>
    </button>

    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/images/kopsurat.png') }}" alt="Kop Surat RNS" class="logo-kopsurat">
        </div>

        <div class="document-info">
            <div class="info-left">
                <table>
                    <tr>
                        <td style="width: 40px;">No.</td>
                        <td style="width: 15px;">:</td>
                        <td>{{ $surat_penawaran->no_sph }}</td>
                    </tr>
                    <tr>
                        <td style="padding-top: 2px;">Hal.</td>
                        <td style="padding-top: 2px;">:</td>
                        <td class="font-bold" style="padding-top: 2px;"><span style="text-decoration: underline;">Penawaran Harga</span></td>
                    </tr>
                </table>
            </div>
            <div class="info-right">
                <p>Serang, {{ \Carbon\Carbon::parse($surat_penawaran->tanggal_sph)->translatedFormat('d F Y') }}</p>
            </div>
        </div>

        <div class="recipient">
            <p>Kepada. Yth</p>
            <p>{{ $surat_penawaran->jabatan_customer }}</p>
            <p>{{ $surat_penawaran->nama_customer }}</p>
            @if($surat_penawaran->alamat_customer)
            <div class="address">{{ $surat_penawaran->alamat_customer }}</div>
            @endif
        </div>

        <div class="intro">
            @php
                $intro = e($surat_penawaran->salam_pembuka);
                // Auto bold product if it exists
                if ($surat_penawaran->items->isNotEmpty()) {
                    $prodName = $surat_penawaran->items->first()->nama_barang;
                    $intro = str_replace($prodName, "<strong>$prodName</strong>", $intro);
                }
                // Convert **text** to <strong>text</strong>
                $intro = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $intro);
            @endphp
            <p style="white-space: pre-line; margin: 0;">{!! $intro !!}</p>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th>Nama Barang</th>
                    <th style="width: 70px;">Qty</th>
                    <th style="width: 150px;">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($surat_penawaran->items as $idx => $item)
                <tr>
                    <td class="text-center font-bold">{{ $idx + 1 }}</td>
                    <td>
                        <div class="font-bold uppercase tracking-tight">{{ $item->nama_barang }}</div>
                        @if($item->spesifikasi)
                        <div class="item-spec">{{ $item->spesifikasi }}</div>
                        @endif
                    </td>
                    <td class="text-center">{{ number_format($item->kuantitas, 0, ',', '.') }} {{ $item->satuan }}</td>
                    <td class="text-right font-bold">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }},-</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3" class="text-right font-bold uppercase" style="padding: 6px;">Total harga</td>
                    <td class="text-right font-bold" style="padding: 6px;">Rp {{ number_format($surat_penawaran->total_harga, 0, ',', '.') }},-</td>
                </tr>
            </tbody>
        </table>

        <div class="terbilang-row">
            {{ app(App\Http\Controllers\SuratPenawaranController::class)->terbilang($surat_penawaran->total_harga) }} Rupiah
        </div>

        <div style="margin-top: 10px;">
            @if($surat_penawaran->syarat_ketentuan)
            <div class="section-title">Catatan:</div>
            <div class="info-content">
                {!! preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', e($surat_penawaran->syarat_ketentuan)) !!}
            </div>
            @endif

            @if($surat_penawaran->keterangan_pembayaran)
            <div class="section-title">Cara pembayaran:</div>
            <div class="info-content">
                {!! preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', e($surat_penawaran->keterangan_pembayaran)) !!}
            </div>
            @endif
        </div>

        <div class="closing">
            <p style="white-space: pre-line; margin: 0;">
                {!! preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', e($surat_penawaran->salam_penutup)) !!}
            </p>
        </div>

        <div class="footer">
            <div class="signature">
                <p style="margin: 0 0 2px 0;">Hormat kami</p>
                <p class="font-bold uppercase" style="margin: 0 0 5px 0; font-size: 11px;">PT. RANAY NUSANTARA SEJAHTERA</p>
                
                @if($surat_penawaran->penandatangan == 'Dewi Sulistiowati')
                    <img src="{{ asset('assets/images/ttdDewi.png') }}" alt="TTD Dewi" class="img-ttd">
                @elseif(str_contains($surat_penawaran->penandatangan, 'Heri Pirdaus'))
                    <img src="{{ asset('assets/images/ttdHeri.png') }}" alt="TTD Heri" class="img-ttd">
                @else
                    <div style="height: 60px;"></div>
                @endif
                
                <p class="name" style="margin: 2px 0 0 0;">{{ $surat_penawaran->penandatangan }}</p>
            </div>
        </div>

        <div class="footer-image-container">
            <img src="{{ asset('assets/images/footerrns.png') }}" alt="Footer RNS" class="footer-image">
        </div>
    </div>

    @php
        $allItemsImages = [];
        foreach($surat_penawaran->items as $item) {
            // Priority 1: Custom Item Photos
            if (!empty($item->images)) {
                foreach($item->images as $img) {
                    $allItemsImages[] = [
                        'path' => $img,
                        'name' => $item->nama_barang
                    ];
                }
            } 
            // Priority 2: Stock Photos (Fall back if no custom photos)
            else if ($item->barang && count($item->barang->barangMasuks ?? []) > 0) {
                foreach($item->barang->barangMasuks as $bm) {
                    $rawImgs = $bm->images;
                    $imgs = [];
                    
                    if (is_string($rawImgs)) {
                        $decoded = json_decode($rawImgs, true);
                        if (is_string($decoded)) {
                            $decoded = json_decode($decoded, true);
                        }
                        $imgs = is_array($decoded) ? $decoded : [];
                    } elseif (is_array($rawImgs)) {
                        $imgs = $rawImgs;
                    }

                    if (!empty($imgs)) {
                        foreach($imgs as $img) {
                            $allItemsImages[] = [
                                'path' => $img,
                                'name' => $item->nama_barang
                            ];
                        }
                    }
                }
            }
        }
    @endphp

    @if(count($allItemsImages) > 0)
    <div class="page-break"></div>
    
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/images/kopsurat.png') }}" alt="Kop Surat RNS" class="logo-kopsurat">
        </div>

        <div style="text-align: center; margin-bottom: 20px;">
            <h2 style="text-decoration: underline; text-transform: uppercase; margin: 0;">Lampiran Gambar Produk</h2>
            <p style="margin: 5px 0 0 0; font-size: 12px;">No. SPH: {{ $surat_penawaran->no_sph }}</p>
        </div>

        <div class="image-gallery">
            @foreach($allItemsImages as $imgData)
                <div class="gallery-item">
                    <img src="{{ asset('storage/' . $imgData['path']) }}" class="gallery-img" alt="Produk">
                    <div class="gallery-caption">{{ $imgData['name'] }}</div>
                </div>
            @endforeach
        </div>

        <div class="footer-image-container">
            <img src="{{ asset('assets/images/footerrns.png') }}" alt="Footer RNS" class="footer-image">
        </div>
    </div>
    @endif
</body>
</html>
