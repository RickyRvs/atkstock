<?php
// GANTI FILE INI: routes/web.php (timpa yang lama)

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StokAwalController;
use App\Http\Controllers\PengaturanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Struktur route sistem stok ATK/ARK.
| Semua route (kecuali login) dilindungi middleware 'auth'.
| Halaman admin dilindungi middleware 'role:admin'.
|
*/

// ============================================================
// AUTH ROUTES (disediakan Laravel Breeze)
// ============================================================
require __DIR__.'/auth.php';

// ============================================================
// ROUTES YANG BUTUH LOGIN
// ============================================================
Route::middleware('auth')->group(function () {

    // ----------------------------------------------------------
    // Dashboard
    // ----------------------------------------------------------
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // ----------------------------------------------------------
    // Master Barang
    // ----------------------------------------------------------
    Route::resource('barang', BarangController::class);

    // ----------------------------------------------------------
    // Kategori
    // ----------------------------------------------------------
    Route::resource('kategori', KategoriController::class);

    // ----------------------------------------------------------
    // Stok Awal (input stok awal per bulan)
    // ----------------------------------------------------------
    Route::prefix('stok-awal')->name('stok-awal.')->group(function () {
        Route::get('/', [StokAwalController::class, 'index'])->name('index');
        Route::get('/create', [StokAwalController::class, 'create'])->name('create');
        Route::post('/', [StokAwalController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [StokAwalController::class, 'edit'])->name('edit');
        Route::put('/{id}', [StokAwalController::class, 'update'])->name('update');
    });

    // ----------------------------------------------------------
    // Transaksi Barang Masuk
    // ----------------------------------------------------------
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        // History semua transaksi (dengan filter)
        Route::get('/', [TransaksiController::class, 'index'])->name('index');

        // Barang Masuk
        Route::get('/masuk/create', [TransaksiController::class, 'createMasuk'])->name('masuk.create');
        Route::post('/masuk', [TransaksiController::class, 'storeMasuk'])->name('masuk.store');

        // Barang Keluar
        Route::get('/keluar/create', [TransaksiController::class, 'createKeluar'])->name('keluar.create');
        Route::post('/keluar', [TransaksiController::class, 'storeKeluar'])->name('keluar.store');

        // Detail transaksi
        Route::get('/{id}', [TransaksiController::class, 'show'])->name('show');

        // Hapus transaksi (soft delete, admin only)
        Route::delete('/{id}', [TransaksiController::class, 'destroy'])
            ->name('destroy')
            ->middleware('role:admin');
    });

    // ----------------------------------------------------------
    // Laporan
    // ----------------------------------------------------------
    Route::prefix('laporan')->name('laporan.')->group(function () {
    Route::get('/kartu-persediaan', [LaporanController::class, 'kartuPersediaan'])->name('kartu-persediaan');
    Route::get('/kartu-persediaan/{barangId}', [LaporanController::class, 'kartuPersediaanDetail'])->name('kartu-persediaan.detail');
    Route::get('/bulanan', [LaporanController::class, 'bulanan'])->name('bulanan');
    Route::get('/tahunan', [LaporanController::class, 'tahunan'])->name('tahunan');
    Route::get('/export/excel', [LaporanController::class, 'exportExcel'])->name('export.excel');
    Route::get('/export/pdf', [LaporanController::class, 'exportPdf'])->name('export.pdf');
    Route::get('/export/pdf/kartu', [LaporanController::class, 'exportPdfKartu'])->name('export.pdf.kartu');
    Route::get('/export/pdf/tahunan', [LaporanController::class, 'exportPdfTahunan'])->name('export.pdf.tahunan');
});

    // ----------------------------------------------------------
    // Manajemen User (Admin Only)
    // ----------------------------------------------------------
    Route::resource('users', UserController::class)
        ->middleware('role:admin');

    // ----------------------------------------------------------
    // Pengaturan Sistem (Admin Only)
    // ----------------------------------------------------------
    Route::prefix('pengaturan')->name('pengaturan.')->middleware('role:admin')->group(function () {
        Route::get('/', [PengaturanController::class, 'edit'])->name('edit');
        Route::put('/', [PengaturanController::class, 'update'])->name('update');
    });

});