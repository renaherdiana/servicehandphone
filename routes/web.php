<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HandphoneController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceItemController;
use App\Http\Controllers\ServiceDetailController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

//dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Daftar Pengguna 
Route::get('/pengguna', [UserController::class, 'index'])->name('pengguna.index');
Route::get('/pengguna/create', [UserController::class, 'create'])->name('pengguna.create');
Route::post('/pengguna', [UserController::class, 'store'])->name('pengguna.store');
Route::get('/pengguna/{id}', [UserController::class, 'show'])->name('pengguna.show');
Route::get('/pengguna/{id}/edit', [UserController::class, 'edit'])->name('pengguna.edit');
Route::put('/pengguna/{id}', [UserController::class, 'update'])->name('pengguna.update');
Route::delete('/pengguna/{id}', [UserController::class, 'destroy'])->name('pengguna.destroy');

//handphone
Route::get('/handphone', [HandphoneController::class, 'index'])->name('handphone.index');
Route::get('/handphone/create', [HandphoneController::class, 'create'])->name('handphone.create');
Route::post('/handphone', [HandphoneController::class, 'store'])->name('handphone.store');
Route::get('/handphone/{id}', [HandphoneController::class, 'show'])->name('handphone.show');
Route::get('/handphone/{id}/edit', [HandphoneController::class, 'edit'])->name('handphone.edit');
Route::put('/handphone/{id}', [HandphoneController::class, 'update'])->name('handphone.update');
Route::delete('/handphone/{id}', [HandphoneController::class, 'destroy'])->name('handphone.destroy');


//service
Route::get('/service', [ServiceController::class, 'index'])->name('service');
Route::get('/service/create', [ServiceController::class, 'create'])->name('service.create');
Route::post('/service', [ServiceController::class, 'store'])->name('service.store');
Route::get('/service/{id}', [ServiceController::class, 'show'])->name('service.show');
Route::get('/service/{id}/edit', [ServiceController::class, 'edit'])->name('service.edit');
Route::put('/service/{id}', [ServiceController::class, 'update'])->name('service.update');
Route::delete('/service/{id}', [ServiceController::class, 'destroy'])->name('service.destroy');

//service item
Route::get('/service-item', [ServiceItemController::class, 'index'])->name('service.item');
Route::get('/service-item/create', [ServiceItemController::class, 'create'])->name('service.item.create');
Route::post('/service-item/store', [ServiceItemController::class, 'store'])->name('service.item.store');
Route::get('/service-item/{id}/edit', [ServiceItemController::class, 'edit'])->name('service.item.edit');
Route::put('/service-item/{id}', [ServiceItemController::class, 'update'])->name('service.item.update');
Route::delete('/service-item/{id}', [ServiceItemController::class, 'destroy'])->name('service.item.destroy');

//pembayaran
Route::get('/pembayaran', [PaymentController::class, 'index'])->name('payment.index');
Route::get('/service/{id}/payment', [PaymentController::class, 'create'])->name('payment.create');
Route::post('/service/{id}/payment', [PaymentController::class, 'store'])->name('payment.store');
Route::get('/service/{id}/detail-payment', [PaymentController::class, 'show'])->name('payment.show');

//customer
Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create');
Route::post('/customer', [CustomerController::class, 'store'])->name('customer.store');
Route::get('/customer/{id}', [CustomerController::class, 'show'])->name('customer.show');
Route::get('/customer/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
Route::put('/customer/{id}', [CustomerController::class, 'update'])->name('customer.update');
Route::delete('/customer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');

//teknisi
Route::get('/teknisi', [TechnicianController::class, 'index'])->name('technician.index');
Route::get('/teknisi/create', [TechnicianController::class, 'create'])->name('technician.create');
Route::post('/teknisi', [TechnicianController::class, 'store'])->name('technician.store');
Route::get('/teknisi/{id}', [TechnicianController::class, 'show'])->name('technician.show');
Route::get('/teknisi/{id}/edit', [TechnicianController::class, 'edit'])->name('technician.edit');
Route::put('/teknisi/{id}', [TechnicianController::class, 'update'])->name('technician.update');
Route::delete('/teknisi/{id}', [TechnicianController::class, 'destroy'])->name('technician.destroy');

});