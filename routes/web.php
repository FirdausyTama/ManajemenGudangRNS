<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
});
Route::get('/login', function () {
    return view('Auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function () {
    return view('Auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashbor.dashboard');
    })->name('dashboard');

    // Kelola Admin (Owner Only)
    Route::middleware('owner')->group(function () {
        Route::get('/admin/manage', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.manage');
        Route::post('/admin/approve/{id}', [\App\Http\Controllers\AdminController::class, 'approve'])->name('admin.approve');
        Route::post('/admin/reject/{id}', [\App\Http\Controllers\AdminController::class, 'reject'])->name('admin.reject');
        
        // Settings / Landing Page CMS
        Route::get('/admin/settings', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
        Route::post('/admin/settings', [\App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
        Route::post('/admin/settings/reset', [\App\Http\Controllers\SettingController::class, 'reset'])->name('settings.reset');
        Route::post('/admin/settings/image/{key}/delete', [\App\Http\Controllers\SettingController::class, 'deleteImage'])->name('settings.deleteImage');
    });

    // Barang Masuk
    Route::resource('/admin/barang-masuk', \App\Http\Controllers\BarangMasukController::class)->except(['create', 'show', 'edit'])->names([
        'index'   => 'barang-masuk.index',
        'store'   => 'barang-masuk.store',
        'update'  => 'barang-masuk.update',
        'destroy' => 'barang-masuk.destroy',
    ]);

    // Monitoring Stok
    Route::get('/admin/monitoring-stok', [\App\Http\Controllers\MonitoringStokController::class, 'index'])->name('monitoring-stok.index');
    Route::post('/admin/monitoring-stok/scan', [\App\Http\Controllers\MonitoringStokController::class, 'scan'])->name('monitoring-stok.scan');
    Route::get('/admin/monitoring-stok/{barang}/print-barcode', [\App\Http\Controllers\MonitoringStokController::class, 'printBarcode'])->name('monitoring-stok.print-barcode');
    Route::delete('/admin/monitoring-stok/{id}', [\App\Http\Controllers\MonitoringStokController::class, 'destroy'])->name('monitoring-stok.destroy');
});