<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rekanan extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function dokumenRekanans()
    {
        return $this->hasMany(DokumenRekanan::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->kode_rekanan)) {
                $latest = self::withTrashed()->orderBy('id', 'desc')->first();
                $nextId = $latest ? $latest->id + 1 : 1;
                $model->kode_rekanan = 'RK' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
