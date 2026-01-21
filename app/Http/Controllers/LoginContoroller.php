<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginContoroller extends Controller
{
    public function showLoginForm()
    {
         return view('login');
    }
}
