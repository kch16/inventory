<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StockLogController extends Controller
{
    public function Input(Request $request, $id)
    {
        //quertString action의 default value는 in으로
        $action = $request->query('action', 'in');

        if(!in_array($action,['in','out']))
        {
            abort(400,'잘못된 실행 값입니다.');
        }

        $title = ($action == 'in') ? '입고 등록' : '출고 등록';

        //Product 조회 (or 404)
        $product = Product::findOrFail($id);

        //blade 뷰에 product 전달
        return view('stock.input',compact('product','title','action'));
    }
}
