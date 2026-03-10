<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $fillable = [
        'barang_id',
        'user_id',
        'incoming_date',
        'quantity',
        'images',
    ];

    protected $casts = [
        'incoming_date' => 'date',
        'images' => 'array',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
