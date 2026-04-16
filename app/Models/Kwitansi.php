<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kwitansi extends Model
{
    protected $guarded = ['id'];

    public static function generateNumber($date)
    {
        $year = date('Y', strtotime($date));
        $latest = self::whereYear('tanggal_kwitansi', $year)->latest('id')->first();
        $nextId = $latest ? $latest->id + 1 : 1;
        return 'KWT/' . str_pad($nextId, 3, '0', STR_PAD_LEFT) . '/RNS/' . $year;
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
