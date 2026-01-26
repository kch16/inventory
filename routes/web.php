<?php

use App\Http\Controllers\LoginContoroller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login',[LoginContoroller::class,'showLoginForm'])->name('login');
Route::post('/login',[LoginContoroller::class,'Login'])->name('login.process');