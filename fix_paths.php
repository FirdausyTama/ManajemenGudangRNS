<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\DokumenRekanan;

$docs = DokumenRekanan::all();
foreach ($docs as $doc) {
    if (strpos($doc->file_path, 'public/') === 0) {
        $doc->file_path = str_replace('public/', '', $doc->file_path);
        $doc->save();
        echo "Updated DB path for: " . $doc->nama_file . "\n";
    }
}

echo "URL for dokumen_rekanan/test.pdf: " . Illuminate\Support\Facades\Storage::disk('public')->url('dokumen_rekanan/test.pdf') . "\n";
