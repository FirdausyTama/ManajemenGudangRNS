<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Rekanan</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f3f4f6; }
        .text-center { text-align: center; }
        .title { font-size: 16px; font-weight: bold; text-align: center; margin-bottom: 5px; }
        .subtitle { font-size: 12px; text-align: center; color: #555; }
    </style>
</head>
<body>

    <div class="title">Data Rekanan (Customer, Supplier, Vendor)</div>
    <div class="subtitle">Dicetak pada: {{ date('d-m-Y H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Perusahaan</th>
                <th>Jenis</th>
                <th>PIC</th>
                <th>Kontak</th>
                <th>Kota / Provinsi</th>
                <th>Status</th>
                <th>Jml Dokumen</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekanans as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->kode_rekanan }}</td>
                <td>{{ $item->nama_perusahaan }}</td>
                <td>{{ $item->jenis_rekanan }}</td>
                <td>{{ $item->nama_pic ?: '-' }}</td>
                <td>{{ $item->no_hp ?: '-' }}</td>
                <td>{{ $item->kota ? $item->kota . ', ' . $item->provinsi : '-' }}</td>
                <td>{{ $item->status }}</td>
                <td class="text-center">{{ $item->dokumen_rekanans_count ?? 0 }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
