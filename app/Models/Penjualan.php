<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\PenjualanItem;

class Penjualan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_transaksi' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(PenjualanItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function kwitansis()
    {
        return $this->hasMany(Kwitansi::class);
    }

    public function suratJalans()
    {
        return $this->hasMany(SuratJalan::class);
    }
}
