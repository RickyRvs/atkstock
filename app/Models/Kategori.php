<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'instansi_id',
    ];

    protected static function booted()
    {
        static::addGlobalScope('instansi', function (Builder $builder) {
            if ($id = session('instansi_aktif_id')) {
                $builder->where('kategoris.instansi_id', $id);
            }
        });

        static::creating(function ($model) {
            if (empty($model->instansi_id)) {
                $model->instansi_id = session('instansi_aktif_id');
            }
        });
    }

    // =========================================================================
    // RELASI
    // =========================================================================

    public function instansi(): BelongsTo
    {
        return $this->belongsTo(Instansi::class, 'instansi_id');
    }

    /**
     * Kategori ini memiliki banyak barang.
     */
    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class, 'kategori_id');
    }

    /**
     * Hanya barang yang aktif.
     */
    public function barangsAktif(): HasMany
    {
        return $this->hasMany(Barang::class, 'kategori_id')->where('is_active', true);
    }
}