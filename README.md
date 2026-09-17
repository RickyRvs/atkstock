# Sistem Stok ATK/ARK (atkstock)

Aplikasi manajemen stok ATK/ARK (Alat Tulis Kantor/Alat Rumah Tangga Kantor) berbasis web, dibangun dengan Laravel. Mendukung banyak instansi dalam satu sistem, pencatatan barang masuk/keluar, stok awal per bulan, hingga laporan bulanan/tahunan yang bisa diekspor ke PDF & Excel.

## Fitur Utama

- **Master Barang & Kategori** — kelola data barang ATK/ARK beserta kategorinya.
- **Stok Awal** — input stok awal per bulan sebagai basis perhitungan stok berjalan.
- **Transaksi Barang Masuk & Keluar** — pencatatan mutasi stok lengkap dengan riwayat.
- **Dashboard** — ringkasan stok, barang hampir habis/habis, tren 6 bulan terakhir, dan distribusi barang per kategori.
- **Laporan** — laporan bulanan, tahunan, dan kartu persediaan per barang; bisa diekspor ke **PDF** (dompdf) dan **Excel** (maatwebsite/excel).
- **Multi-Instansi** — satu akun bisa terhubung ke beberapa instansi (provinsi/kabupaten/kota) dan berpindah instansi aktif.
- **Manajemen User & Role** — role `admin` dan `petugas`, dengan halaman Manajemen User & Pengaturan Sistem khusus admin.

## Tech Stack

- **Backend:** Laravel 11 (PHP ^8.2)
- **Database:** MySQL
- **Frontend:** Blade + Tailwind CSS (CDN), Alpine.js
- **Export:** barryvdh/laravel-dompdf (PDF), maatwebsite/excel (Excel)
- **Auth:** Laravel Breeze

## Cara Pasang (Instalasi)

### 1. Prasyarat

Pastikan sudah terpasang di komputer/server:
- PHP >= 8.2
- Composer
- MySQL (atau MariaDB)
- Node.js & NPM

### 2. Clone / Extract Project

```bash
git clone https://github.com/RickyRvs/atkstock.git
cd atkstock
```

### 3. Install Dependency

```bash
composer install
npm install
```

### 4. Konfigurasi Environment

Salin file environment lalu sesuaikan:

```bash
cp .env.example .env
php artisan key:generate
```

Buka `.env` dan sesuaikan koneksi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stok_atk
DB_USERNAME=root
DB_PASSWORD=
```

Buat database `stok_atk` (nama bebas, sesuaikan dengan `DB_DATABASE`) di MySQL terlebih dahulu.

### 5. Migrasi & Seeder

```bash
php artisan migrate --seed
```

Perintah ini akan membuat seluruh tabel sekaligus mengisi data awal: daftar instansi (BPS se-Riau), kategori & contoh barang, serta 2 akun default berikut.

| Role | Email | Password |
|---|---|---|
| Admin | `admin@bps.go.id` | `admin123` |
| Petugas | `petugas@bps.go.id` | `petugas123` |

> ⚠️ **Wajib ganti password akun default ini setelah aplikasi live di server produksi.**

### 6. Build Asset Frontend

```bash
npm run build
```

> Jika kamu sedang development dan menjalankan `npm run dev`, pastikan proses itu dihentikan (Ctrl+C) dan file `public/hot` ikut terhapus sebelum deploy ke server produksi — kalau tidak, sebagian halaman auth akan tampil tanpa styling.

### 7. Jalankan Aplikasi

Untuk development lokal:

```bash
php artisan serve
```

Aplikasi bisa diakses di `http://127.0.0.1:8000`.

Untuk production, arahkan document root web server (Apache/Nginx) ke folder `public/`.

## Checklist Sebelum Deploy ke Production

- [ ] Set `APP_ENV=production` dan `APP_DEBUG=false` di `.env`
- [ ] Generate `APP_KEY` baru khusus server production (`php artisan key:generate`)
- [ ] Ganti password akun `admin` dan `petugas` bawaan seeder
- [ ] Jalankan `npm run build` dan pastikan file `public/hot` **tidak ada**
- [ ] Jalankan `php artisan config:cache` dan `php artisan route:cache` untuk performa
- [ ] Pastikan folder `storage/` dan `bootstrap/cache/` writable oleh web server

## Struktur Peran (Role)

- **admin** — akses penuh: Manajemen User, Pengaturan Sistem, hapus transaksi, dan seluruh modul lainnya.
- **petugas** — akses ke modul operasional harian (barang, kategori, stok awal, transaksi, laporan) tanpa akses Manajemen User & Pengaturan Sistem.

## Lisensi

Proyek ini dibangun di atas framework [Laravel](https://laravel.com), yang merupakan open-source software dengan lisensi [MIT](https://opensource.org/licenses/MIT).
