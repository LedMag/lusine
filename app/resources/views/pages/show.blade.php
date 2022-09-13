@extends('main')

@section('name')
{{ __('show') }}
@endsection

@section('content')

<div class="product">
    {{-- <img class="product__item" src="{{ asset('/storage/catalog/' . $product->url ) }}" alt="{{ $product->name }}" /> --}}
    <p class="product__name">{{$product->name}}</p>
    <p class="product__description">{{$product->description}}</p>
    {{-- <p class="product__price">{{$product->price}}</p> --}}
    <p class="product__category">{{$product->category_id}}</p>
    <p class="product__collection">{{$product->collection_id}}</p>
    {{-- @auth --}}
    {{-- <a href="{{ route('show.product', $product)}}" class="btn">{{__('edit')}}</a> --}}
    {{-- @endauth --}}
</div>

@auth
  <div class="product__wrapp">
    <form action="{{ route('addSlide') }}" method="POST" enctype="multipart/form-data" class="product__form">
      @csrf
      <input name="image" type="file" class="product__image">
      <input name="name" type="text" class="product__name">
      <input name="description_en" type="text" class="product__description">
      <input name="description_es" type="text" class="product__description">
      <input name="description_ru" type="text" class="product__description">
      <input name="price" type="number" class="product__price">
      <select class="product__category">
        @foreach($categories as $category)
        <option value="{{$category}}">{{$category}}</option>
        @endforeach
      </select>
      <select class="product__collection">
        @foreach($collections as $collection)
        <option value="{{$collection}}">{{$collection}}</option>
        @endforeach
      </select>
      <button type="submit" class="btn">{{__('send')}}</button>
    </form>
  </div>
@endauth
    
@endsection