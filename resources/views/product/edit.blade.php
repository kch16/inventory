@extends('layout')

@section('main')
  <div class="py-4">
    <h2 class="mb-4 text-center">📝 상품 수정</h2>
    <form method="post" action="{{route('product.update',$product)}}" enctype="multipart/form-data" class="mx-auto" style="max-width: 600px;">
       @csrf
       @method('PUT') 
        <div class="mb-3">
            <label class="form-label">상품명</label>
            <input type="text" name="name" class="form-control" value="{{old('name',$product->name)}}" required>
            @error('name')
                <div class="alert alert-danger text-center">{{$message}}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">SKU</label>
            <input type="text" name="sku" class="form-control" value="{{old('sku',$product->sku)}}" required>
            @error('sku')
                <div class="alert alert-danger text-center">{{$message}}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">가격 (원)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{old('price',$product->price)}}" required>
            @error('price')
                <div class="alert alert-danger text-center">{{$message}}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">상품 이미지(선택사항)</label>
            <input type="file" name="image" class="form-control">
            @if($product->image)
                <div class="mt-2">
                    <img src="{{asset('storage/',$product->image)}}" style="max-width: 200px; height:auto">
                </div>
            @endif
        </div>

        <div class="d-grid gap-2">
            <button class="btn btn-success">저장</button>
            <a href="products.php" class="btn btn-outline-secondary">취소</a>
        </div>
    </form>
</div>  
@endsection