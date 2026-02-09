<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function Index(){
        $title='상품목록';
        $products = Product::searchKeyword();
        return view('product.list',compact('title','products'));
    }

    public function Input(){
        $title='상품추가';
        return view('product.input',compact('title'));
    }

    public function Store(Request $request)
    {
        /*
        if(empty($request->input('name')))
        {
            return redirect()->back()->withInput()->with('error','상품명은 필수입력 값입니다.');
        }
        */
        $request->validate([
            'name'=>'required|unique:products,name',
            'sku'=>'required|string|unique:products,sku',
            'quantity'=>'required|numeric',
            'price'=>'required|numeric'
            ],
            [
            'name.required'=>'상품명은 필수입력 항목 입니다.',
            'name.unique'=>'이미 등록된 상품명 입니다.',
            'sku.required'=>'SKU는 필수입력 항목 입니다.',
            'sku.string'=>'SKU는 문자열이어야 합니다.',
            'sku.unique'=>'이미 등록된 SKU 입니다.',
            'quantity.required'=>'수량은 필수입력 항목 입니다.',
            'quantity.numeric'=>'수량은 숫자이어야 합니다.',
            'price.required'=>'가격은 필수입력 항목 입니다.',
            'price.numeric'=>'가격은 숫자이어야 합니다.'
        ]);

        $arr = [
            'name'=>$request->input('name'),
            'sku'=>$request->input('sku'),
            'quantity'=>$request->input('quantity'),
            'price'=>$request->input('price'),
        ];

        //상품이미지를 업로드한 경우
        if(!empty($request->file('image')))
        {
            $request->validate(['image'=>'required|file|mimes:jpg,jpeg,git,png|max:4096']); //4mb 이하 파일
            $path=$request->file('image')->store('uploads','public');
            $arr['image']=$path;
        }

        //대량할당
        Product::create($arr);

        return redirect()->route('dashboard')->with('success','등록되었습니다.');

    }
}
