<?php

use App\Http\Controllers\AdministrasiController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrasiPasienController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RegistrasiPasienController::class, 'create']);
Route::resource('registrasipasien', RegistrasiPasienController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup middleware untuk semua rute yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    
    // Rute untuk mengedit, memperbarui, dan menghapus profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk resource controller yang memerlukan autentikasi
    Route::resource('home', HomeController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('pasien', PasienController::class);
    Route::resource('poli', PoliController::class);
    Route::resource('user', UserController::class);
    Route::resource('profil', ProfilController::class);
    Route::resource('administrasi', AdministrasiController::class);
    Route::resource('jadwal', JadwalController::class);
    Route::get('/getDokterByPoli/{poliId}', [PasienController::class, 'getDokterByPoli']);
    Route::get('/getJadwalByDokter/{dokterId}', [PasienController::class, 'getJadwalByDokter']);
    Route::get('/get-poli-by-pasien/{id}', [AdministrasiController::class, 'getPoliByPasien']);

});


require __DIR__.'/auth.php';
