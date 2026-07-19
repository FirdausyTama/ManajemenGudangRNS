<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_po',
        'supplier_name',
        'supplier_address',
        'tanggal_po',
        'pembayaran',
        'catatan',
        'penandatangan',
        'total_harga',
        'user_id',
    ];

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Auto generate PO number format: 002/P-RAND/IV/2026
    public static function generateNoPo()
    {
        $lastPo = self::orderBy('id', 'desc')->first();
        $lastNumber = $lastPo ? intval(substr($lastPo->no_po, 0, 3)) : 0;
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        
        $romanMonths = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        $month = $romanMonths[date('n')];
        $year = date('Y');

        return "{$newNumber}/P-RAND/{$month}/{$year}";
    }
}
