<?php

namespace App\Exports;

use App\Models\Rekanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RekananExport implements FromCollection, WithHeadings, WithMapping
{
    protected $rekanans;

    public function __construct($rekanans)
    {
        $this->rekanans = $rekanans;
    }

    public function collection()
    {
        return $this->rekanans;
    }

    public function headings(): array
    {
        return [
            'Kode Rekanan',
            'Jenis Rekanan',
            'Nama Perusahaan',
            'Nama PIC',
            'Jabatan PIC',
            'No HP',
            'Email',
            'NPWP',
            'NIB',
            'Alamat',
            'Kota',
            'Provinsi',
            'Kode Pos',
            'Website',
            'Status',
            'Jumlah Dokumen',
            'Tanggal Dibuat',
        ];
    }

    public function map($rekanan): array
    {
        return [
            $rekanan->kode_rekanan,
            $rekanan->jenis_rekanan,
            $rekanan->nama_perusahaan,
            $rekanan->nama_pic,
            $rekanan->jabatan_pic,
            $rekanan->no_hp,
            $rekanan->email,
            $rekanan->npwp,
            $rekanan->nib,
            $rekanan->alamat,
            $rekanan->kota,
            $rekanan->provinsi,
            $rekanan->kode_pos,
            $rekanan->website,
            $rekanan->status,
            $rekanan->dokumen_rekanans_count ?? 0,
            $rekanan->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
