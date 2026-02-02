<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function Input(){
        $title='상품추가';
        return view('product.input',compact('title'));
    }
}
