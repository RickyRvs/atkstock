<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
    ];

    // =========================================================================
    // RELASI
    // =========================================================================

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
