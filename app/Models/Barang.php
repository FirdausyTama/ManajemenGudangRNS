<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'factory',
        'merek',
        'unit',
        'purchase_price',
        'selling_price',
        'stock',
        'barcode_path',
        'user_id',
    ];

    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
