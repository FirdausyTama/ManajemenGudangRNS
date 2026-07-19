<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>PO_{{ str_replace('/', '_', $purchaseOrder->no_po) }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Times+New+Roman:wght@400;700&display=swap');
        
        @page {
            margin: 0;
            size: A4 portrait;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            margin: 0;
            padding: 0;
            background: #fff;
            font-size: 14px;
        }

        .document-container {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 10mm 15mm;
            position: relative;
            box-sizing: border-box;
        }

        .content {
            position: relative;
            z-index: 2;
        }

        .header {
            text-align: center;
            margin-bottom: 5px;
            padding-bottom: 10px;
        }

        .logo-kopsurat {
            width: 100%;
            max-width: 100%;
            height: auto;
        }

        .date-right {
            text-align: right;
            margin-top: 5px;
            margin-bottom: 20px;
        }

        .document-title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 30px;
        }

        .info-section {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }

        .info-left {
            display: table-cell;
            width: 45%;
            border: 2px solid #5a8bc6;
            padding: 10px;
            vertical-align: top;
        }
        
        .info-right {
            display: table-cell;
            width: 35%;
            border: 2px solid #5a8bc6;
            padding: 10px;
            vertical-align: top;
            text-align: center;
            font-weight: bold;
        }

        .info-spacer {
            display: table-cell;
            width: 20%;
        }

        .info-left h3 {
            margin: 0 0 5px 0;
            font-size: 16px;
            font-weight: bold;
        }

        .info-left p {
            margin: 0;
            font-size: 14px;
        }

        table.items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        table.items-table th, table.items-table td {
            border: 2px solid #000;
            padding: 5px;
            text-align: center;
        }

        table.items-table th {
            background-color: #cde4f7;
            font-weight: bold;
            font-size: 14px;
        }

        table.items-table td {
            font-size: 14px;
        }

        table.items-table td:nth-child(2) {
            text-align: left;
        }

        .total-row td {
            font-weight: bold;
        }
        
        .terbilang-row td {
            font-style: italic;
            text-align: right;
            border: none;
            padding-right: 0;
        }

        .footer-note {
            margin-top: 30px;
            font-size: 14px;
            line-height: 1.5;
        }

        .signature-section {
            margin-top: 40px;
            width: 300px;
        }

        .signature-section p {
            margin: 0;
            line-height: 1.5;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }

        .stamp-img {
            width: 150px;
            height: auto;
            margin: 10px 0;
            position: relative;
            left: -20px;
        }

        .footer-image-container {
            position: absolute;
            bottom: 0mm;
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
        
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            width: 70%;
            z-index: 1;
            pointer-events: none;
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
            z-index: 9999;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background-color: #f8fafc;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            color: #1e3a8a;
        }
        
        @media print {
            .no-print { display: none; }
            .btn-floating-print, .btn-back { display: none !important; }
            .document-container { padding: 5mm 15mm; width: 100%; background: none; }
            .watermark { display: block !important; }
        }
    </style>
</head>
<body onload="window.print()">
    <button onclick="window.close(); window.history.back();" class="btn-back" title="Kembali / Tutup Halaman">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
        </svg>
        <span>Kembali / Tutup</span>
    </button>

    <button onclick="window.print()" class="btn-floating-print" title="Cetak PO">
        <svg viewBox="0 0 24 24"><path d="M19 8H5V3H19V8ZM16 5H8V6H16V5ZM22 13.5C22 14.33 21.33 15 20.5 15C19.67 15 19 14.33 19 13.5C19 12.67 19.67 12 20.5 12C21.33 12 22 12.67 22 13.5ZM18 19H6V15H18V19ZM19 22H5V17H2.99C1.89 17 1 16.1 1 15V11C1 9.34 2.34 8 4 8H20C21.66 8 23 9.34 23 11V15C23 16.1 22.11 17 21.01 17H19V22Z"/></svg>
    </button>

    <div class="document-container">
        <img src="{{ asset('assets/images/logo-rns-bg.png') }}" class="watermark" alt="Watermark">
        
        <div class="content">
            <!-- Header (Kop Surat) -->
            <div class="header">
                <img src="{{ asset('assets/images/kopsurat.png') }}" class="logo-kopsurat" alt="Kop Surat">
            </div>

            <!-- Date -->
            <div class="date-right">
                Banten, {{ \Carbon\Carbon::parse($purchaseOrder->tanggal_po)->translatedFormat('d F Y') }}
            </div>

            <!-- Title -->
            <div class="document-title">
                Purchase Order
            </div>

            <!-- Info Section -->
            <div class="info-section">
                <div class="info-left">
                    <h3>{{ $purchaseOrder->supplier_name }}</h3>
                    <p>{{ $purchaseOrder->supplier_address }}</p>
                </div>
                <div class="info-spacer"></div>
                <div class="info-right">
                    No. PO : {{ $purchaseOrder->no_po }}
                </div>
            </div>

            <!-- Table Items -->
            <table class="items-table">
                <thead>
                    <tr>
                        <th width="5%">NO</th>
                        <th width="30%">DESKRIPSI</th>
                        <th width="15%">SATUAN</th>
                        <th width="15%">QTY</th>
                        <th width="15%">HARGA</th>
                        <th width="20%">TOTAL HARGA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchaseOrder->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}.</td>
                        <td>{{ $item->deskripsi }}</td>
                        <td>{{ $item->satuan }}</td>
                        <td>{{ floatval($item->kuantitas) }} {{ $item->satuan }}</td>
                        <td>Rp. {{ number_format($item->harga_satuan, 0, ',', '.') }},-</td>
                        <td>Rp. {{ number_format($item->total_harga, 0, ',', '.') }},-</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="4" style="border: none;"></td>
                        <td style="text-align: right; border: 2px solid #000;">Total</td>
                        <td style="border: 2px solid #000;">Rp. {{ number_format($purchaseOrder->total_harga, 0, ',', '.') }},-</td>
                    </tr>
                </tbody>
            </table>

            <!-- Terbilang (Optional based on image it has italic text below total) -->
            @php
                function penyebut($nilai) {
                    $nilai = abs($nilai);
                    $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
                    $temp = "";
                    if ($nilai < 12) {
                        $temp = " ". $huruf[$nilai];
                    } else if ($nilai <20) {
                        $temp = penyebut($nilai - 10). " Belas";
                    } else if ($nilai < 100) {
                        $temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
                    } else if ($nilai < 200) {
                        $temp = " Seratus" . penyebut($nilai - 100);
                    } else if ($nilai < 1000) {
                        $temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
                    } else if ($nilai < 2000) {
                        $temp = " Seribu" . penyebut($nilai - 1000);
                    } else if ($nilai < 1000000) {
                        $temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
                    } else if ($nilai < 1000000000) {
                        $temp = penyebut($nilai/1000000) . " Juta" . penyebut(fmod($nilai, 1000000));
                    } else if ($nilai < 1000000000000) {
                        $temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai, 1000000000));
                    } else if ($nilai < 1000000000000000) {
                        $temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai, 1000000000000));
                    }     
                    return $temp;
                }
                function terbilang($nilai) {
                    if($nilai<0) {
                        $hasil = "minus ". trim(penyebut($nilai));
                    } else {
                        $hasil = trim(penyebut($nilai));
                    }           
                    return $hasil;
                }
            @endphp
            <div style="text-align: right; font-style: italic; margin-bottom: 20px;">
                ({{ terbilang($purchaseOrder->total_harga) }} Rupiah)
            </div>

            <!-- Footer Note -->
            <div class="footer-note">
                <p style="white-space: pre-line;">{{ $purchaseOrder->catatan }}</p>
            </div>

            <!-- Signature -->
            <div class="signature-section">
                <p>Hormat Kami</p>
                <p><strong>PT RAND NUSANTARA SEJAHTERA</strong></p>
                
                @if($purchaseOrder->penandatangan == 'Dewi Sulistiowati')
                    <img src="{{ asset('assets/images/ttdDewi.png') }}" class="stamp-img" alt="Tanda Tangan & Cap">
                @elseif(str_contains($purchaseOrder->penandatangan, 'Heri Pirdaus'))
                    <img src="{{ asset('assets/images/ttdHeri.png') }}" class="stamp-img" alt="Tanda Tangan & Cap">
                @else
                    <div style="height: 60px;"></div>
                @endif
                
                <p class="signature-name">{{ strtoupper($purchaseOrder->penandatangan) }}</p>
            </div>
        </div>

        <div class="footer-image-container">
            <img src="{{ asset('assets/images/footerrns.png') }}" alt="Footer RNS" class="footer-image">
        </div>
    </div>
    
    <script>
        // Auto print when requested (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
