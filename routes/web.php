<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::prefix('admin')->group(function(){
        Route::get('home', [AdminController::class, 'home'])->name('homeAdmin');
        Route::get('pesanan', [AdminController::class, 'pesanan'])->name('pesananAdmin');
        Route::get('user', [AdminController::class, 'user'])->name('userAdmin');
        Route::get('destroy/{id_hotel}', [AdminController::class,'destroy'])->name('destroy');
        Route::post('store', [AdminController::class,'store'])->name('store');
        Route::get('create', [AdminController::class,'create'])->name('create');
        Route::get('show/{id_hotel}', [AdminController::class,'show'])->name('show');
        Route::get('edit/{id_hotel}', [AdminController::class,'edit'])->name('edit');
        Route::post('update/{id_hotel}', [AdminController::class,'update'])->name('update');
        Route::post('deleteMultiple', [AdminController::class,'deleteMultiple'])->name('deleteMultiple');
        Route::get('filter', [AdminController::class,'filter'])->name('filterAdmin');
        Route::get('search', [AdminController::class,'search'])->name('searchAdmin');
    });
    Route::prefix('user')->group(function(){
        Route::get('home', [UserController::class, 'home'])->name('homeUser');
        Route::get('booking/{id_hotel}', [UserController::class, 'booking'])->name('bookingUser');
        Route::get('orders', [UserController::class, 'orders'])->name('ordersUser');
        Route::get('filter', [UserController::class,'filter'])->name('filterUser');
        Route::get('search', [UserController::class,'search'])->name('searchUser');
        Route::post('store/{id}', [UserController::class,'store'])->name('storeUser');
    });
});



Route::fallback(function(){
    return "Hmmm, Mengapa orang gila seperti anda bisa mendarat disini!";
});

require __DIR__.'/auth.php';