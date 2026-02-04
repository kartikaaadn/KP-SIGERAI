<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gerai extends Model
{
    protected $table = 'gerais';

    protected $fillable = [
        'nama_gerai',
        'instansi',
        'lokasi_counter',
        'pic_nama',
        'pic_kontak',
        'deskripsi',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'gerai_id');
    }

    public function layananHarians(): HasMany
    {
        return $this->hasMany(LayananHarian::class, 'gerai_id');
    }
}
