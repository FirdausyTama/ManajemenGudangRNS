<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

/* |-------------------------------------------------------------------------- | AUTH ROUTES |-------------------------------------------------------------------------- */
Route::get('/', function () {
    return view('landing');
});
Route::get('/login', function () {
    return view('Auth.login');
})->name('login');
Route::post('/login', [AuthController::class , 'login']);

Route::get('/register', function () {
    return view('Auth.register');
})->name('register');
Route::post('/register', [AuthController::class , 'register']);

Route::post('/logout', [AuthController::class , 'logout'])->name('logout');

use App\Http\Controllers\DashboardController;

/* |-------------------------------------------------------------------------- | DASHBOARD |-------------------------------------------------------------------------- */
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Kelola Admin (Owner Only)
        Route::middleware('owner')->group(function () {
            Route::get('/admin/manage', [\App\Http\Controllers\AdminController::class , 'index'])->name('admin.manage');
            Route::post('/admin/approve/{id}', [\App\Http\Controllers\AdminController::class , 'approve'])->name('admin.approve');
            Route::post('/admin/reject/{id}', [\App\Http\Controllers\AdminController::class , 'reject'])->name('admin.reject');

            // Settings / Landing Page CMS
            Route::get('/admin/settings', [\App\Http\Controllers\SettingController::class , 'index'])->name('settings.index');
            Route::post('/admin/settings', [\App\Http\Controllers\SettingController::class , 'update'])->name('settings.update');
            Route::post('/admin/settings/reset', [\App\Http\Controllers\SettingController::class , 'reset'])->name('settings.reset');
            Route::post('/admin/settings/image/{key}/delete', [\App\Http\Controllers\SettingController::class , 'deleteImage'])->name('settings.deleteImage');
        }
        );

        // Barang Masuk
        Route::resource('/admin/barang-masuk', \App\Http\Controllers\BarangMasukController::class)->except(['create', 'show', 'edit'])->names([
            'index' => 'barang-masuk.index',
            'store' => 'barang-masuk.store',
            'update' => 'barang-masuk.update',
            'destroy' => 'barang-masuk.destroy',
        ]);

        // Monitoring Stok
        Route::get('/admin/monitoring-stok', [\App\Http\Controllers\MonitoringStokController::class , 'index'])->name('monitoring-stok.index');
        Route::post('/admin/monitoring-stok/scan', [\App\Http\Controllers\MonitoringStokController::class , 'scan'])->name('monitoring-stok.scan');
        Route::get('/admin/monitoring-stok/{barang}/print-barcode', [\App\Http\Controllers\MonitoringStokController::class , 'printBarcode'])->name('monitoring-stok.print-barcode');
        Route::delete('/admin/monitoring-stok/{id}', [\App\Http\Controllers\MonitoringStokController::class , 'destroy'])->name('monitoring-stok.destroy');

        // Kelola Penjualan
        Route::resource('/admin/penjualan', \App\Http\Controllers\PenjualanController::class)->except(['create', 'edit'])->names([
            'index' => 'penjualan.index',
            'store' => 'penjualan.store',
            'update' => 'penjualan.update',
            'destroy' => 'penjualan.destroy',
        ]);
        Route::patch('/admin/penjualan/{penjualan}/status', [\App\Http\Controllers\PenjualanController::class , 'updateStatus'])->name('penjualan.updateStatus');
        Route::get('/admin/penjualan/{penjualan}/invoice', [\App\Http\Controllers\PenjualanController::class , 'printInvoice'])->name('penjualan.invoice');

        // Surat Invoice
        Route::get('/admin/invoice', [\App\Http\Controllers\InvoiceController::class , 'index'])->name('invoice.index');
        Route::post('/admin/invoice', [\App\Http\Controllers\InvoiceController::class , 'store'])->name('invoice.store');
        Route::get('/admin/invoice/{invoice}/print', [\App\Http\Controllers\InvoiceController::class , 'print'])->name('invoice.print');
        Route::delete('/admin/invoice/{invoice}', [\App\Http\Controllers\InvoiceController::class , 'destroy'])->name('invoice.destroy');
        Route::post('/admin/invoice/bulk-destroy', [\App\Http\Controllers\InvoiceController::class , 'bulkDestroy'])->name('invoice.bulkDestroy');
        Route::post('/admin/penjualan/{penjualan}/set-tenor', [\App\Http\Controllers\PenjualanController::class , 'setTenor'])->name('penjualan.setTenor');
        Route::post('/admin/penjualan/{penjualan}/cicilan', [\App\Http\Controllers\PenjualanController::class , 'storeCicilan'])->name('penjualan.storeCicilan');


        // Surat Kwitansi
        Route::get('/admin/kwitansi', [\App\Http\Controllers\KwitansiController::class , 'index'])->name('kwitansi.index');
        Route::post('/admin/kwitansi', [\App\Http\Controllers\KwitansiController::class , 'store'])->name('kwitansi.store');
        Route::get('/admin/kwitansi/{kwitansi}/print', [\App\Http\Controllers\KwitansiController::class , 'print'])->name('kwitansi.print');
        Route::delete('/admin/kwitansi/{kwitansi}', [\App\Http\Controllers\KwitansiController::class , 'destroy'])->name('kwitansi.destroy');
        Route::post('/admin/kwitansi/bulk-destroy', [\App\Http\Controllers\KwitansiController::class , 'bulkDestroy'])->name('kwitansi.bulkDestroy');

        // Surat Jalan
        Route::get('/admin/surat-jalan', [\App\Http\Controllers\SuratJalanController::class , 'index'])->name('surat-jalan.index');
        Route::post('/admin/surat-jalan', [\App\Http\Controllers\SuratJalanController::class , 'store'])->name('surat-jalan.store');
        Route::get('/admin/surat-jalan/{surat_jalan}/print', [\App\Http\Controllers\SuratJalanController::class , 'print'])->name('surat-jalan.print');
        Route::delete('/admin/surat-jalan/{surat_jalan}', [\App\Http\Controllers\SuratJalanController::class , 'destroy'])->name('surat-jalan.destroy');
        Route::post('/admin/surat-jalan/bulk-destroy', [\App\Http\Controllers\SuratJalanController::class , 'bulkDestroy'])->name('surat-jalan.bulkDestroy');

        // Laporan Keuntungan
        Route::get('/admin/laporan-keuntungan', [\App\Http\Controllers\LaporanKeuntunganController::class , 'index'])->name('laporan-keuntungan.index');

        // Surat Penawaran Harga (SPH)
        Route::get('/admin/surat-penawaran', [\App\Http\Controllers\SuratPenawaranController::class , 'index'])->name('surat-penawaran.index');
        Route::post('/admin/surat-penawaran', [\App\Http\Controllers\SuratPenawaranController::class , 'store'])->name('surat-penawaran.store');
        Route::put('/admin/surat-penawaran/{surat_penawaran}', [\App\Http\Controllers\SuratPenawaranController::class , 'update'])->name('surat-penawaran.update');
        Route::get('/admin/surat-penawaran/{surat_penawaran}/print', [\App\Http\Controllers\SuratPenawaranController::class , 'print'])->name('surat-penawaran.print');
        Route::delete('/admin/surat-penawaran/{surat_penawaran}', [\App\Http\Controllers\SuratPenawaranController::class , 'destroy'])->name('surat-penawaran.destroy');
        Route::post('/admin/surat-penawaran/bulk-destroy', [\App\Http\Controllers\SuratPenawaranController::class , 'bulkDestroy'])->name('surat-penawaran.bulkDestroy');
    });