<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratPenawaranItem extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'images' => 'array'
    ];

    public function suratPenawaran()
    {
        return $this->belongsTo(SuratPenawaran::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
