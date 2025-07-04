<?php

use App\Http\Controllers\AdministrasiController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
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
// Route::middleware('auth')->group(function () {
    
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
    Route::resource('artikel', ArtikelController::class);
    Route::resource('kategori', KategoriController::class);
    Route::get('/getDokterByPoli/{poliId}', [PasienController::class, 'getDokterByPoli']);
    Route::get('/getJadwalByDokter/{dokterId}', [PasienController::class, 'getJadwalByDokter']);
    Route::get('/get-poli-by-pasien/{id}', [AdministrasiController::class, 'getPoliByPasien']);
    Route::get('laporan/administrasi', [LaporanController::class, 'index'])->name('laporan.adm');
    Route::get('/administrasi/{id}/print', [AdministrasiController::class, 'printAntrian'])->name('administrasi.print');
    Route::post('/check-jam-kunjungan', [PasienController::class, 'checkJamKunjungan']);
    Route::get('/doctors', [DokterController::class, 'publicIndex'])->name('doctors.public');
    Route::get('/services', [PoliController::class, 'publicIndex'])->name('services.public');
// });

Route::resource('blog', BlogController::class);
Route::get('/single', [BlogController::class, 'single_blog'])->name('single');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/category/{slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/search', [BlogController::class, 'search'])->name('blog.search');
Route::post('/blog/comment/{articleId}', [BlogController::class, 'storeComment'])->name('blog.comment.store');



require __DIR__.'/auth.php';
