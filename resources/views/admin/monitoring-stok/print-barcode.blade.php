<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Barcode - {{ $barang->sku }}</title>
    <style>
        body {
            font-family: sans-serif;
            text-align: center;
            margin: 0;
            padding: 20px;
            display: block;
        }
        .print-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .barcode-container {
            border: 1px dashed #aaa;
            padding: 20px;
            border-radius: 8px;
            display: inline-block;
            background: #fff;
            width: 300px; /* Fixed width for standard label size simulation */
            text-align: left;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 16px;
        }

        .details {
            font-size: 12px;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        .details div {
            display: flex;
            justify-content: space-between;
        }

        .details div span:first-child {
            color: #555;
        }

        .details div span:last-child {
            font-weight: bold;
            text-align: right;
            max-width: 60%;
        }

        .barcode-section {
            text-align: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed #ccc;
        }

        .barcode-img {
            max-width: 100%;
            height: 60px; /* Lebar otomatis, tinggi disesuaikan */
        }
        .sku {
            margin-top: 5px;
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #000;
            font-family: monospace;
        }

        /* Styling khusus saat proses printing */
        @media print {
            @page {
                margin: 0; /* Menghilangkan header/footer browser default */
            }
            body { 
                margin: 0; 
                padding: 0; 
                display: block; 
                text-align: left; /* Atur ke kiri atau tengah sesuai selera label printer */
            }
            .print-wrapper {
                gap: 5mm;
                justify-content: flex-start;
            }
            .barcode-container { 
                border: 1px dotted #ccc; /* Beri batas halus agar tahu gari potong jika diprint di A4 */
                padding: 15px; 
                width: 300px; /* Pertahankan lebar standar (jangan 100%) */
                max-width: 100%; /* Antisipasi jika kertas lebih kecil dari 300px */
                margin: 0; /* Hilangkan pemusatan otomatis jika ingin di pojok */
                break-inside: avoid; /* Mencegah terpotong 2 halaman */
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <!-- Container -->
    <div class="print-wrapper">
        @for($i = 0; $i < $qty; $i++)
        <div class="barcode-container">
            
            <div class="header">
                {{ Str::limit($barang->name, 50) }}
            </div>

            <div class="details">
                <div>
                    <span>Merek:</span>
                    <span>{{ $barang->merek ?: '-' }}</span>
                </div>
                <div>
                    <span>Pabrik:</span>
                    <span>{{ $barang->factory ?: '-' }}</span>
                </div>
                <div>
                    <span>Satuan:</span>
                    <span style="text-transform: uppercase;">{{ $barang->unit ?: '-' }}</span>
                </div>
                
                <div style="margin-top: 5px; font-size: 14px;">
                    <span>Harga Jual:</span>
                    <span>Rp {{ number_format($barang->selling_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="barcode-section">
                <img src="{{ Storage::url($barang->barcode_path) }}" class="barcode-img" alt="Barcode {{ $barang->sku }}">
                <div class="sku">{{ $barang->sku }}</div>
            </div>

        </div>
        @endfor
    </div>
</body>
</html>
