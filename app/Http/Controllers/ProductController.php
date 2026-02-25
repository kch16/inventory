<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
//use Symfony\Component\HttpKernel\HttpCache\Store;

class ProductController extends Controller
{
    public function Index(){
        $title='상품목록';
        $products = Product::searchKeyword();
        return view('product.list',compact('title','products'));
    }

    public function Input()
    {
        $title='상품추가';
        return view('product.input',compact('title'));
    }

    public function Store(Request $request, StockService $stock)
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
            'quantity'=>0,
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
        $product = Product::create($arr);

        //초기 재고가 있으면 세팅
        if(isset($request->quantity) && $request->quantity > 0)
        {
            $stock->setInitialStock($product,(int) $request->quantity);
        }

        return redirect()->route('dashboard')->with('success','등록되었습니다.');
    }

    public function Destroy($id)
    {
        $product = Product::findOrFail($id);
        //이미지 파일 존재 여부 
        if(!empty($product->image))
        {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('product')->with('success','상품이 삭제되었습니다.');
    }

    public function Edit(Product $product)
    {
        $title = "상품수정";
        return view('product.edit', compact('product','title'));
    }

    public function Update(Request $request, Product $product)
    {
        //입력값 검증
        $request->validate([
            'name' => 'required|string',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        //데이터 업데이트
        $product->name = $request->input('name');
        $product->sku = $request->input('sku');
        $product->price = $request->input('price');
        if($request->hasFile('image'))
        {
            if($product->image && Storage::disk('publice')->exists($product->image))
            {
                Storage::disk('public')->delete($product->image);
                //storage 파사드를 이용해 삭제
                //저장 장치가 변하더라도 코드 수정없이 대응
            }

            $path = $request->file('image')->store('uploades','public');
            //$path=Storage::disk('public')->putFile('uploads',$request->file('image));
            //주석과 같이 동작
            $product->image=$path;
        }

        //저장
        $product->save();

        //응답
        return redirect()->route('product')->with('success','상품이 수정됩니다.');
    }
}
