<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>KWITANSI_{{ $kwitansi->nama_penerima }}_{{ \Carbon\Carbon::parse($kwitansi->tanggal_kwitansi)->format('d_m_Y') }}</title>
    <style>
        @page {
            margin: 0;
            size: A4;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            font-size: 14px;
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
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .logo-kopsurat {
            width: 100%;
            max-width: 800px;
            height: auto;
        }
        .title-box {
            text-align: center;
            margin-bottom: 30px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #1e3a8a;
            text-decoration: underline;
            margin-bottom: 5px;
        }
        .nomor {
            font-size: 14px;
            color: #555;
        }
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .content-table td {
            padding: 12px 10px;
            vertical-align: top;
        }
        .label-col {
            width: 30%;
        }
        .label-primary {
            font-weight: 700;
            color: #475569;
            font-size: 14px;
            margin-bottom: 2px;
        }
        .label-secondary {
            font-style: italic;
            color: #64748b;
            font-size: 14px;
        }
        .colon-col {
            width: 2%;
            padding-top: 15px !important;
            color: #475569;
        }
        .value-col {
            width: 68%;
        }
        .value-box {
            background-color: #e0f2fe;
            border: 1px solid #93c5fd;
            padding: 10px 15px;
            border-radius: 2px;
            color: #334155;
            font-size: 15px;
            min-height: 24px;
            display: flex;
            align-items: center;
        }
        .value-box-strong {
            font-weight: 700;
        }
        .value-box-italic {
            font-style: italic;
            color: #475569;
        }
        .footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 50px;
        }
        .signature-box {
            text-align: center;
            width: 250px;
        }
        .signature-img {
            max-width: 120px;
            height: auto;
            margin: 10px 0;
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
        .watermark {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            
            box-sizing: border-box;
            object-fit: contain;
            opacity: 0.1;
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
            pointer-events: auto !important;
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
            body {
                background: white;
            }
            .container {
                padding: 5mm 15mm;
                width: 100%;
                background: none;
            }
            .watermark { display: block !important; }
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
    <!-- print -->
    <button onclick="window.print()" class="btn-floating-print" title="Cetak Kwitansi">
        <svg viewBox="0 0 24 24"><path d="M19 8H5V3H19V8ZM16 5H8V6H16V5ZM22 13.5C22 14.33 21.33 15 20.5 15C19.67 15 19 14.33 19 13.5C19 12.67 19.67 12 20.5 12C21.33 12 22 12.67 22 13.5ZM18 19H6V15H18V19ZM19 22H5V17H2.99C1.89 17 1 16.1 1 15V11C1 9.34 2.34 8 4 8H20C21.66 8 23 9.34 23 11V15C23 16.1 22.11 17 21.01 17H19V22Z"/></svg>
    </button>

    <div class="container">
        <img src="{{ asset('assets/images/logo-rns-bg.png') }}" class="watermark" alt="Watermark">
        <div class="header">
            <img src="{{ asset('assets/images/kopsurat.png') }}" alt="Kop Surat RNS" class="logo-kopsurat" onerror="this.src=''">
        </div>

        <!-- TOP SECTION -->
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <!-- Left side KWITANSI TO -->
            <table style="width: 48%; border-collapse: collapse; border: 1px solid #000;">
                <tr>
                    <td style="background-color: #93c5fd; text-align: center; font-weight: bold; border-bottom: 1px solid #000; padding: 4px; font-size: 13px;">KWITANSI TO</td>
                </tr>
                <tr>
                    <td style="background-color: #dbeafe; padding: 10px; height: 85px; vertical-align: top;">
                        <div style="font-weight: bold; font-size: 14px;">{{ strtoupper($kwitansi->nama_penerima) }}</div>
                        <div style="margin-top: 5px; font-size: 13px;">{{ $kwitansi->alamat_penerima }}</div>
                    </td>
                </tr>
            </table>

            <!-- Right side No Kwitansi & Tanggal -->
            <div style="width: 45%; display: flex; align-items: flex-start; justify-content: flex-end;">
                <table style="width: 100%; border-collapse: collapse; border: 1px solid #000; font-size: 13px;">
                    <tr>
                        <td style="background-color: #93c5fd; padding: 4px 8px; border: 1px solid #000; width: 40%;">No Kwitansi</td>
                        <td style="background-color: #dbeafe; padding: 4px 8px; border: 1px solid #000; font-weight: bold;">{{ $kwitansi->nomor_kwitansi }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #93c5fd; padding: 4px 8px; border: 1px solid #000;">Tanggal</td>
                        <td style="background-color: #dbeafe; padding: 4px 8px; border: 1px solid #000;">{{ \Carbon\Carbon::parse($kwitansi->tanggal_kwitansi)->format('d/m/Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- RECEIPT TITLE -->
        <div style="text-align: center; margin-bottom: 25px;">
            <div style="font-size: 18px; font-weight: bold; letter-spacing: 5px; text-decoration: underline; margin-bottom: 3px;">R E C E I P T</div>
            <div style="font-size: 15px; font-weight: bold; letter-spacing: 2px;">KWITANSI</div>
        </div>

        <!-- FORM CONTENT -->
        <table style="width: 100%; border-collapse: separate; border-spacing: 0 15px; font-size: 14px;">
            <tr>
                <td style="width: 20%; vertical-align: middle;">
                    <div style="border-bottom: 1px solid #000; padding-bottom: 2px;">Received From</div>
                    <div style="padding-top: 2px;">Sudah Terima Dari</div>
                </td>
                <td style="width: 3%; text-align: center; vertical-align: middle;">:</td>
                <td style="width: 77%;">
                    <div style="background-color: #dbeafe; border: 1px solid #000; padding: 6px 10px; font-weight: bold; color: #1e3a8a;">
                        {{ strtoupper($kwitansi->nama_penerima) }}
                    </div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: middle;">
                    <div style="border-bottom: 1px solid #000; padding-bottom: 2px;">Amount in Words</div>
                    <div style="padding-top: 2px;">Banyaknya Uang</div>
                </td>
                <td style="text-align: center; vertical-align: middle;">:</td>
                <td>
                    <div style="background-color: #dbeafe; border: 1px solid #000; padding: 6px 10px; font-style: italic; color: #1e3a8a;">
                        {{ ucwords(strtolower($kwitansi->total_bilangan)) }} Rupiah
                    </div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: middle;">
                    <div style="border-bottom: 1px solid #000; padding-bottom: 2px;">For Payment of</div>
                    <div style="padding-top: 2px;">Untuk Pembayaran</div>
                </td>
                <td style="text-align: center; vertical-align: middle;">:</td>
                <td>
                    <div style="background-color: #dbeafe; border: 1px solid #000; padding: 6px 10px; color: #1e3a8a;">
                        {{ $kwitansi->keterangan }}
                    </div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: middle;">
                    <div style="border-bottom: 1px solid #000; padding-bottom: 2px;">Total</div>
                    <div style="padding-top: 2px;">Jumlah</div>
                </td>
                <td style="text-align: center; vertical-align: middle;">:</td>
                <td style="vertical-align: middle;">
                    <div style="background-color: #dbeafe; border: 1px solid #000; padding: 6px 10px; display: inline-block; font-weight: bold; color: #1e3a8a; min-width: 150px;">
                        Rp. {{ number_format($kwitansi->total_pembayaran, 0, ',', '.') }},-
                    </div>
                </td>
            </tr>
        </table>

        <div class="footer">
            
            <div class="signature-box">
                <div>Serang, {{ \Carbon\Carbon::parse($kwitansi->tanggal_kwitansi)->translatedFormat('d F Y') }}</div>
                
                <div style="height: 10px;"></div>
                @if(strpos(strtolower($kwitansi->penandatangan), 'dewi') !== false)
                    <img src="{{ asset('assets/images/ttdDewi.png') }}" alt="TTD Dewi" class="signature-img" onerror="this.src=''; this.alt='(Tanda Tangan)'">
                @else
                    <img src="{{ asset('assets/images/ttdHeri.png') }}" alt="TTD Heri" class="signature-img" onerror="this.src=''; this.alt='(Tanda Tangan)'">
                @endif
                <div style="height: 10px;"></div>
                
                <div style="font-weight: bold; text-decoration: underline;">{{ $kwitansi->penandatangan }}</div>
                <div style="font-size: 12px; color: #666;">PT. Rand Nusantara Sejahtera</div>
            </div>
        </div>
        
        <div class="footer-image-container">
            <img src="{{ asset('assets/images/footerrns.png') }}" alt="Footer RNS" class="footer-image">
        </div>
    </div>
</body>
</html>
