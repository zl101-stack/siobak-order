<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\Admin\MenuAdminController;
use App\Http\Controllers\Admin\QrCodeController;

// ==========================================
// CUSTOMER (Mobile) Routes
// ==========================================

// Landing page — customer input nomor meja
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Halaman menu (bisa langsung dari URL atau redirect dari landing)
Route::get('/menu/{table}', [MenuController::class, 'index'])->name('menu.index');

// Cart / Konfirmasi pesanan
Route::get('/confirm/{table}', function ($table) {
    return view('order.confirmation', compact('table'));
})->name('order.confirmation');

// Submit order
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

// Lihat status order
Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');

// API: polling status order oleh customer
Route::get('/api/order/{id}/status', [OrderController::class, 'status']);


// ==========================================
// PAYMENT (Simulasi QRIS)
// ==========================================

Route::get('/payment/{orderId}', [PaymentController::class, 'index'])->name('payment.index');
Route::post('/payment/{orderId}/simulate', [PaymentController::class, 'simulatePay'])->name('payment.simulate');
Route::get('/api/payment/{orderId}/status', [PaymentController::class, 'checkStatus']);


// ==========================================
// KITCHEN Dashboard
// ==========================================

Route::get('/kitchen', [KitchenController::class, 'index'])->name('kitchen.index');
Route::post('/kitchen/order/{id}/status', [KitchenController::class, 'updateStatus'])->name('kitchen.update-status');
Route::patch('/kitchen/order/{id}/table', [KitchenController::class, 'updateTable'])->name('kitchen.update-table');

// API: polling order baru untuk kitchen
Route::get('/api/kitchen/new-orders', [KitchenController::class, 'newOrders']);
Route::get('/api/kitchen/all-orders', [KitchenController::class, 'allOrders']);


// ==========================================
// ADMIN Panel
// ==========================================

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.menus.index');
    })->name('index');

    // Menu management
    Route::get('/menus', [MenuAdminController::class, 'index'])->name('menus.index');
    Route::post('/menus', [MenuAdminController::class, 'store'])->name('menus.store');
    Route::put('/menus/{id}', [MenuAdminController::class, 'update'])->name('menus.update');
    Route::patch('/menus/{id}/stock', [MenuAdminController::class, 'updateStock'])->name('menus.update-stock');
    Route::delete('/menus/{id}', [MenuAdminController::class, 'destroy'])->name('menus.destroy');

    // QR Code
    Route::get('/qrcode', [QrCodeController::class, 'index'])->name('qrcode.index');
    Route::get('/qrcode/download', [QrCodeController::class, 'generate'])->name('qrcode.download');
});
