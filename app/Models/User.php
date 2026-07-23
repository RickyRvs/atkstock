<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi massal (mass assignment).
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi (misal ke JSON/array).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    // =========================================================================
    // RELASI
    // =========================================================================

    /**
     * Transaksi yang diinput oleh user ini.
     */
    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'user_id');
    }

    /**
     * Stok awal yang dibuat oleh user ini.
     */
    public function stokAwals(): HasMany
    {
        return $this->hasMany(StokAwal::class, 'created_by');
    }

    // =========================================================================
    // HELPER / ACCESSOR
    // =========================================================================

    /**
     * Cek apakah user adalah admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah petugas.
     */
    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }
}
