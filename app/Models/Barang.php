<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'satuan',
        'kategori_id',
        'keterangan',
        'is_active',
        'instansi_id',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected static function booted()
    {
        static::addGlobalScope('instansi', function (Builder $builder) {
            if ($id = session('instansi_aktif_id')) {
                $builder->where('barangs.instansi_id', $id);
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
     * Barang ini milik satu kategori.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Semua transaksi (masuk & keluar) untuk barang ini.
     */
    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'barang_id');
    }

    /**
     * Hanya transaksi masuk untuk barang ini.
     */
    public function transaksiMasuk(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'barang_id')->where('jenis', 'masuk');
    }

    /**
     * Hanya transaksi keluar untuk barang ini.
     */
    public function transaksiKeluar(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'barang_id')->where('jenis', 'keluar');
    }

    /**
     * Stok awal per bulan untuk barang ini.
     */
    public function stokAwals(): HasMany
    {
        return $this->hasMany(StokAwal::class, 'barang_id');
    }

    // =========================================================================
    // HELPER / BUSINESS LOGIC
    // =========================================================================

    public function getStokAwal(int $bulan, int $tahun): int
    {
        $stok = $this->stokAwals()
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        return $stok ? $stok->jumlah : 0;
    }

    public function getTotalMasuk(int $bulan, int $tahun): int
    {
        return $this->transaksiMasuk()
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');
    }

    public function getTotalKeluar(int $bulan, int $tahun): int
    {
        return $this->transaksiKeluar()
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');
    }

    /**
     * Rumus: Stok Akhir = Stok Awal + Total Masuk - Total Keluar
     */
    public function getStokAkhir(int $bulan, int $tahun): int
    {
        $stokAwal    = $this->getStokAwal($bulan, $tahun);
        $totalMasuk  = $this->getTotalMasuk($bulan, $tahun);
        $totalKeluar = $this->getTotalKeluar($bulan, $tahun);

        return $stokAwal + $totalMasuk - $totalKeluar;
    }

    public function getStokSekarang(): int
    {
        return $this->getStokAkhir(now()->month, now()->year);
    }

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByKategori($query, int $kategoriId)
    {
        return $query->where('kategori_id', $kategoriId);
    }
}