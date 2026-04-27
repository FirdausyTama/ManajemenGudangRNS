<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kwitansi extends Model
{
    protected $guarded = ['id'];

    public static function generateNumber($date)
    {
        $year = date('Y', strtotime($date));
        $month = date('n', strtotime($date));
        $romanMonths = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        
        $count = self::whereYear('tanggal_kwitansi', $year)->count() + 1;
        return str_pad($count, 2, '0', STR_PAD_LEFT) . '/KWT/RNS-' . $romanMonths[$month] . '/' . $year;
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
