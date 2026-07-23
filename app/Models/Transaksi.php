<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transaksis';

    protected $fillable = [
        'barang_id',
        'jenis',
        'tanggal',
        'jumlah',
        'uraian',
        'penerima_sumber',
        'no_dokumen',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'jumlah'  => 'integer',
        ];
    }

    // =========================================================================
    // RELASI
    // =========================================================================

    /**
     * Transaksi ini milik satu barang.
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    /**
     * User yang menginput transaksi ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // =========================================================================
    // SCOPE (untuk filter query yang sering dipakai)
    // =========================================================================

    /**
     * Scope: hanya transaksi masuk.
     */
    public function scopeMasuk($query)
    {
        return $query->where('jenis', 'masuk');
    }

    /**
     * Scope: hanya transaksi keluar.
     */
    public function scopeKeluar($query)
    {
        return $query->where('jenis', 'keluar');
    }

    /**
     * Scope: filter by bulan dan tahun dari kolom tanggal.
     */
    public function scopeByBulanTahun($query, int $bulan, int $tahun)
    {
        return $query->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
    }

    /**
     * Scope: filter by tahun saja.
     */
    public function scopeByTahun($query, int $tahun)
    {
        return $query->whereYear('tanggal', $tahun);
    }

    /**
     * Scope: filter by barang tertentu.
     */
    public function scopeByBarang($query, int $barangId)
    {
        return $query->where('barang_id', $barangId);
    }

    // =========================================================================
    // ACCESSOR / HELPER
    // =========================================================================

    /**
     * Label jenis transaksi yang lebih ramah dibaca.
     */
    public function getJenisLabelAttribute(): string
    {
        return match ($this->jenis) {
            'masuk'  => 'Barang Masuk',
            'keluar' => 'Barang Keluar',
            default  => '-',
        };
    }

    /**
     * Badge warna untuk UI (bisa dipakai di Blade).
     * Contoh: "bg-green-100 text-green-800" untuk masuk.
     */
    public function getJenisBadgeAttribute(): string
    {
        return match ($this->jenis) {
            'masuk'  => 'bg-green-100 text-green-800',
            'keluar' => 'bg-red-100 text-red-800',
            default  => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Format tanggal ke Bahasa Indonesia.
     * Contoh: "Senin, 15 Januari 2024"
     */
    public function getTanggalFormatAttribute(): string
    {
        if (!$this->tanggal) return '-';

        $hari = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];

        $bulan = [
            1  => 'Januari',   2  => 'Februari',  3  => 'Maret',
            4  => 'April',     5  => 'Mei',        6  => 'Juni',
            7  => 'Juli',      8  => 'Agustus',    9  => 'September',
            10 => 'Oktober',   11 => 'November',   12 => 'Desember',
        ];

        $namaHari  = $hari[$this->tanggal->format('l')] ?? '';
        $namaBulan = $bulan[(int) $this->tanggal->format('n')] ?? '';

        return "{$namaHari}, {$this->tanggal->format('d')} {$namaBulan} {$this->tanggal->format('Y')}";
    }
}
