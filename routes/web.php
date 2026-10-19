
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceRecordController;
use Illuminate\Support\Facades\Route;

// Halaman utama
Route::get('/', function () {
    return redirect()->route('service-records.index');
});

// Dashboard setelah login
Route::get('/dashboard', function () {
    return redirect()->route('service-records.index');
})->middleware('auth')->name('dashboard');

// Fitur operasional untuk Admin dan Operator
Route::middleware(['auth', 'role:admin,operator'])->group(function () {
    // Daftar data operasional
    Route::get('/service-records', [
        ServiceRecordController::class,
        'index',
    ])->name('service-records.index');

    // Tambah data
    Route::get('/service-records/create', [
        ServiceRecordController::class,
        'create',
    ])->name('service-records.create');

    Route::post('/service-records', [
        ServiceRecordController::class,
        'store',
    ])->name('service-records.store');

    // Melihat detail data
    Route::get('/service-records/{service_record}', [
        ServiceRecordController::class,
        'show',
    ])->whereNumber('service_record')->name('service-records.show');

    // Mengedit data
    Route::get('/service-records/{service_record}/edit', [
        ServiceRecordController::class,
        'edit',
    ])->whereNumber('service_record')->name('service-records.edit');

    Route::put('/service-records/{service_record}', [
        ServiceRecordController::class,
        'update',
    ])->whereNumber('service_record')->name('service-records.update');
});

// Fitur khusus Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Menghapus data
    Route::delete('/service-records/{service_record}', [
        ServiceRecordController::class,
        'destroy',
    ])->whereNumber('service_record')->name('service-records.destroy');

    // Ekspor CSV
    Route::get('/service-records/export', [
        ServiceRecordController::class,
        'export',
    ])->name('service-records.export');

    // Laporan bulanan
    Route::get('/service-records/monthly-report', [
        ServiceRecordController::class,
        'monthlyReport',
    ])->name('service-records.monthly-report');
});

// Profil pengguna
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Login, logout, dan autentikasi Breeze
require __DIR__.'/auth.php';
