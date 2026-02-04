<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LayananHarian extends Model
{
    protected $table = 'layanan_harians';

    protected $fillable = [
        'gerai_id',
        'tanggal',
        'total_layanan',
        'keterangan',
        'status_verifikasi',
        'created_by',
        'verified_by',
        'verified_at',
        'reject_reason',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'verified_at' => 'datetime',
    ];

    public function gerai(): BelongsTo
    {
        return $this->belongsTo(Gerai::class, 'gerai_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(LayananHarianDetail::class, 'layanan_harian_id');
    }
}
