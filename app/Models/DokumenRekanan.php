<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenRekanan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function rekanan()
    {
        return $this->belongsTo(Rekanan::class);
    }
}
