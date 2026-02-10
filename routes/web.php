<?php

use App\Http\Controllers\LoginContoroller;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function(){
    Route::get('/', function () {
        $title = '대시보드';
        return view('dashboard', compact('title'));
    })->name('dashboard');

    Route::get('/logout', [LoginContoroller::class, 'Logout'])->name('logout');
    Route::get('/product/input',[ProductController::class,'Input'])->name('product.input');
    Route::post('/product/input',[ProductController::class,'Store'])->name('product.store');
    Route::get('/product',[ProductController::class,'Index'])->name('product');
    Route::delete('/product/{id}', [ProductController::class, 'Destroy'])->name('product.delete');

});

Route::get('/login',[LoginContoroller::class,'showLoginForm'])->name('login');
Route::post('/login',[LoginContoroller::class,'Login'])->name('login.process');
