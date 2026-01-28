<?php

use App\Http\Controllers\LoginContoroller;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function(){
    Route::get('/', function () {
        $title = '대시보드';
        return view('dashboard', compact('title'));
    })->name('dashboard');

    Route::get('/logout', [LoginContoroller::class, 'Logout'])->name('logout');
});

Route::get('/login',[LoginContoroller::class,'showLoginForm'])->name('login');
Route::post('/login',[LoginContoroller::class,'Login'])->name('login.process');
