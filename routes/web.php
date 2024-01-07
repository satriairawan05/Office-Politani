<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect(route('login'));
});

// Login & Logout
Route::get('login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login_store');

Route::middleware(['auth'])->group(function () {
    // Home
    Route::get('home', [\App\Http\Controllers\Admin\HomeController::class, 'home'])->name('home');
    Route::get('archive',[\App\Http\Controllers\Admin\HomeController::class, 'archive'])->name('archive');

    Route::resource('role', \App\Http\Controllers\Admin\GroupController::class);
    Route::resource('user', \App\Http\Controllers\Admin\UserController::class);
    Route::get('user/{user}/change',[\App\Http\Controllers\Admin\UserController::class,'formChangePassword'])->name('user.changepassword');
    Route::put('user/{user}/changepassword',[\App\Http\Controllers\Admin\UserController::class,'changePassword'])->name('user.put.changepassword');
    Route::resource('jenis_surat', \App\Http\Controllers\Admin\JenisSuratController::class);
    Route::resource('jurusan', \App\Http\Controllers\Admin\JurusanController::class);
    Route::resource('prodi', \App\Http\Controllers\Admin\ProdiController::class);
    Route::resource('surat_keluar', \App\Http\Controllers\Admin\SuratKeluarController::class);
    Route::put('surat_keluar/{surat_keluar}/verifikasi',[\App\Http\Controllers\Admin\SuratKeluarController::class, 'verifikasi'])->name('surat_keluar.verifikasi');
    Route::resource('verifikasi', \App\Http\Controllers\Admin\VerifikasiController::class);
    Route::resource('signature', \App\Http\Controllers\Admin\SignatureController::class);

    // Logout
    Route::post('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});
