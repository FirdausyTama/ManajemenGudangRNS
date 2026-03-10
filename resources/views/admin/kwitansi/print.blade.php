<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi - {{ $kwitansi->nomor_kwitansi }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 1.5cm;
        }
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            font-size: 14px;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #1e3a8a;
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
            .btn-floating-print {
                display: none !important;
            }
            body {
                background: white;
            }
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="btn-floating-print" title="Cetak Kwitansi">
        <svg viewBox="0 0 24 24"><path d="M19 8H5V3H19V8ZM16 5H8V6H16V5ZM22 13.5C22 14.33 21.33 15 20.5 15C19.67 15 19 14.33 19 13.5C19 12.67 19.67 12 20.5 12C21.33 12 22 12.67 22 13.5ZM18 19H6V15H18V19ZM19 22H5V17H2.99C1.89 17 1 16.1 1 15V11C1 9.34 2.34 8 4 8H20C21.66 8 23 9.34 23 11V15C23 16.1 22.11 17 21.01 17H19V22Z"/></svg>
    </button>

    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/images/kopsurat.png') }}" alt="Kop Surat RNS" class="logo-kopsurat" onerror="this.src=''">
        </div>

        <div class="title-box">
            <div class="title">Kwitansi Dokumen</div>
            <div class="nomor">No. {{ $kwitansi->nomor_kwitansi }}</div>
        </div>

        <table class="content-table">
            <tr>
                <td class="label-col">
                    <div class="label-primary">Received From</div>
                    <div class="label-secondary">Sudah Terima Dari</div>
                </td>
                <td class="colon-col">:</td>
                <td class="value-col">
                    <div class="value-box value-box-strong">
                        {{ $kwitansi->nama_penerima }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="label-col">
                    <div class="label-primary">Amount in Words</div>
                    <div class="label-secondary">Banyaknya Uang</div>
                </td>
                <td class="colon-col">:</td>
                <td class="value-col">
                    <div class="value-box value-box-italic">
                        {{ $kwitansi->total_bilangan }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="label-col">
                    <div class="label-primary">For Payment of</div>
                    <div class="label-secondary">Untuk Pembayaran</div>
                </td>
                <td class="colon-col">:</td>
                <td class="value-col">
                    <div class="value-box">
                        {{ $kwitansi->keterangan }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="label-col" style="padding-top: 20px;">
                    <div class="label-primary">Total</div>
                    <div class="label-secondary">Jumlah</div>
                </td>
                <td class="colon-col" style="padding-top: 35px !important;"></td>
                <td class="value-col" style="padding-top: 20px;">
                    <div class="value-box value-box-strong" style="max-width: 250px;">
                        Rp {{ number_format($kwitansi->total_pembayaran, 0, ',', '.') }},-
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
                <div style="font-size: 12px; color: #666;">PT. Ranay Nusantara Sejahtera</div>
            </div>
        </div>
    </div>
</body>
</html>
