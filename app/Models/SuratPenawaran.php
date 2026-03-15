<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratPenawaran extends Model
{
    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(SuratPenawaranItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
