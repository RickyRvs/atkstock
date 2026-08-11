<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Pengaturan extends Model
{
    protected $table = 'pengaturans';

    protected $fillable = [
        'instansi_id',
        'nama_sistem',
        'nama_instansi',
        'alamat_instansi',
        'kota',
        'logo_path',
        'ttd1_jabatan',
        'ttd1_nama',
        'ttd1_nip',
        'ttd2_jabatan',
        'ttd2_nama',
        'ttd2_nip',
        'ttd3_jabatan',
        'ttd3_nama',
        'ttd3_nip',
    ];

    /**
     * Ambil pengaturan milik instansi yang sedang aktif di session.
     * Kalau belum ada row untuk instansi itu, otomatis dibuatkan default.
     */
    public static function current(): self
    {
        $instansiId = session('instansi_aktif_id');

        return Cache::rememberForever(self::cacheKey($instansiId), function () use ($instansiId) {
            return self::where('instansi_id', $instansiId)->first() ?? self::create([
                'instansi_id'   => $instansiId,
                'nama_sistem'   => 'Sistem Stok ATK/ARK',
                'nama_instansi' => optional(Instansi::find($instansiId))->nama ?? 'BPS Provinsi Riau',
                'kota'          => 'Pekanbaru',
            ]);
        });
    }

    public static function clearCache(?int $instansiId = null): void
    {
        $instansiId = $instansiId ?? session('instansi_aktif_id');
        Cache::forget(self::cacheKey($instansiId));
    }

    protected static function cacheKey(?int $instansiId): string
    {
        return "pengaturan_sistem_{$instansiId}";
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo_path ? asset('storage/' . $this->logo_path) : null;
    }

    public function logoAbsolutePath(): ?string
    {
        if (!$this->logo_path) {
            return null;
        }
        $path = \Illuminate\Support\Facades\Storage::disk('public')->path($this->logo_path);
        return file_exists($path) ? $path : null;
    }

    /**
     * Ambil daftar tanda tangan yang terisi lengkap saja.
     * Slot dianggap valid hanya jika jabatan DAN nama sama-sama diisi.
     * NIP bersifat opsional per slot (boleh kosong).
     */
    public function getTandaTanganAttribute(): array
    {
        $slots = [
            ['jabatan' => $this->ttd1_jabatan, 'nama' => $this->ttd1_nama, 'nip' => $this->ttd1_nip],
            ['jabatan' => $this->ttd2_jabatan, 'nama' => $this->ttd2_nama, 'nip' => $this->ttd2_nip],
            ['jabatan' => $this->ttd3_jabatan, 'nama' => $this->ttd3_nama, 'nip' => $this->ttd3_nip],
        ];

        return array_values(array_filter($slots, function ($s) {
            return !empty(trim($s['jabatan'] ?? '')) && !empty(trim($s['nama'] ?? ''));
        }));
    }
}