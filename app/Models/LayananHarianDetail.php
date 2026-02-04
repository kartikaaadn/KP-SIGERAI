<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LayananHarianDetail extends Model
{
    protected $table = 'layanan_harian_details';

    protected $fillable = [
        'layanan_harian_id',
        'jenis_layanan',
        'jumlah_pengguna',
        'keterangan',
    ];

    public function harian(): BelongsTo
    {
        return $this->belongsTo(LayananHarian::class, 'layanan_harian_id');
    }
}
