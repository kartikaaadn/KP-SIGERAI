<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthGeraiController;
use App\Http\Controllers\GoogleAuthController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AdminMessageController;
use App\Http\Controllers\Admin\AdminProfileController;

use App\Http\Controllers\Gerai\DashboardController as GeraiDashboardController;
use App\Http\Controllers\Gerai\GeraiMessageController;
use App\Http\Controllers\Gerai\GeraiProfileController;
use App\Http\Controllers\Gerai\GeraiLaporanController;

/*
|--------------------------------------------------------------------------
| Landing
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
})->name('landing');

/*
|--------------------------------------------------------------------------
| Login Gerai (VIEW) - FORCE LOGOUT
|--------------------------------------------------------------------------
*/
Route::get('/login-gerai', function () {
    if (Auth::check()) {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }

    return view('auth.login-gerai');
})->name('login.gerai');

/*
|--------------------------------------------------------------------------
| Register Gerai (VIEW)
|--------------------------------------------------------------------------
*/
Route::get('/register-gerai', function () {
    return view('auth.register-gerai');
})->middleware('guest')->name('register.gerai');

/*
|--------------------------------------------------------------------------
| Auth Gerai (Login & Register)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthGeraiController::class, 'showLogin'])
    ->middleware('guest')
    ->name('gerai.login');

Route::post('/login', [AuthGeraiController::class, 'login'])
    ->name('gerai.login.submit');

Route::get('/register', [AuthGeraiController::class, 'showRegister'])
    ->middleware('guest')
    ->name('gerai.register');

Route::post('/register', [AuthGeraiController::class, 'register'])
    ->name('gerai.register.submit');

Route::post('/logout', [AuthGeraiController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Google OAuth
|--------------------------------------------------------------------------
*/
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])
    ->name('google.redirect');

Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])
    ->name('google.callback');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
// ADMIN ROUTES
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/pesan', [AdminMessageController::class, 'index'])
            ->name('pesan.index');

        Route::post('/pesan/send', [AdminMessageController::class, 'send'])
            ->name('pesan.send');

        // ✅ PROFILE ADMIN (FIX route names)
        Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile/update', [AdminProfileController::class, 'updateProfile'])->name('profile.update');
        Route::post('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password');
        Route::post('/profile/avatar', [AdminProfileController::class, 'updateAvatar'])->name('profile.avatar');
    });

/*
|--------------------------------------------------------------------------
| GERAI ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:gerai'])
    ->prefix('gerai')
    ->name('gerai.')
    ->group(function () {

        Route::get('/dashboard', [GeraiDashboardController::class, 'index'])->name('dashboard');

        Route::get('/pesan', [GeraiMessageController::class, 'index'])->name('pesan.index');
        Route::post('/pesan/send', [GeraiMessageController::class, 'send'])->name('pesan.send');

        Route::get('/profile', [GeraiProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile', [GeraiProfileController::class, 'update'])->name('profile.update');

        // ✅ SELURUH LAPORAN (FIX)
        // ✅ SELURUH LAPORAN (GERAI)
        Route::get('/laporan', [GeraiLaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export', [GeraiLaporanController::class, 'export'])->name('laporan.export');

        // input data baru
        Route::get('/laporan/input', [GeraiLaporanController::class, 'create'])->name('laporan.create');
        Route::post('/laporan/save', [GeraiLaporanController::class, 'store'])->name('laporan.store');

        // hapus 1 baris detail
        Route::delete('/laporan/detail/{detail}', [GeraiLaporanController::class, 'destroyDetail'])
            ->name('laporan.detail.destroy');
      
        Route::get('/ranking', function () { return 'Halaman Ranking Top 1-3 (coming soon)'; })->name('ranking.index');
        Route::get('/riwayat', function () { return 'Halaman Riwayat (coming soon)'; })->name('riwayat.index');
        Route::get('/statistika', function () { return 'Halaman Statistika (coming soon)'; })->name('statistika.index');
    });

/*
|--------------------------------------------------------------------------
| Dashboard Fallback (AMAN)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return redirect()->route('login.gerai');
})->name('dashboard');
