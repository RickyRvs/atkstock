<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StokAwal extends Model
{
    use HasFactory;

    protected $table = 'stok_awals';

    protected $fillable = [
        'barang_id',
        'bulan',
        'tahun',
        'jumlah',
        'keterangan',
        'created_by',
        'instansi_id',
    ];

    protected function casts(): array
    {
        return [
            'bulan'  => 'integer',
            'tahun'  => 'integer',
            'jumlah' => 'integer',
        ];
    }

    protected static function booted()
    {
        static::addGlobalScope('instansi', function (Builder $builder) {
            if ($id = session('instansi_aktif_id')) {
                $builder->where('stok_awals.instansi_id', $id);
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
     * Stok awal ini milik satu barang.
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    /**
     * User yang menginput stok awal ini.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // =========================================================================
    // HELPER
    // =========================================================================

    public function getNamaBulanAttribute(): string
    {
        $namaBulan = [
            1  => 'Januari', 2  => 'Februari', 3  => 'Maret',
            4  => 'April',   5  => 'Mei',       6  => 'Juni',
            7  => 'Juli',    8  => 'Agustus',   9  => 'September',
            10 => 'Oktober', 11 => 'November',  12 => 'Desember',
        ];

        return $namaBulan[$this->bulan] ?? '-';
    }

    public function scopeByBulanTahun($query, int $bulan, int $tahun)
    {
        return $query->where('bulan', $bulan)->where('tahun', $tahun);
    }

    public function scopeByTahun($query, int $tahun)
    {
        return $query->where('tahun', $tahun);
    }
}