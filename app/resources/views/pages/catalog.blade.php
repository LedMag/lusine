@extends('main')

@section('name')
{{ __('catalog') }}
@endsection

@section('content')


<div class="catalog">
  @auth
  <div class="control">
    <a href="{{ route('create.product')}}" class="control__btn btn">{{__('add.product')}}</a>
  </div>
  @endauth
  <div class="content">
    @foreach($products as $product)
      <div class="product">
        <img class="product__image" src="{{ asset('storage/' . $product->url ) }}" alt="{{ $product->name }}" />
        <div class="middle">
          <div class="product__info">
            <p class="product__name">{{$product->name}}</p>
            <p class="product__price">€ {{$product->price}}99</p>
          </div>
          @auth
          <div class="product__btns">
            <a href="{{ route('edit.product', $product->id)}}" class="edit">{{__('edit')}}</a>
            
            <form action="{{ route('delete.product', ['id' => $product->id]) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="delete">{{__('delete')}}</button>
            </form>
          </div>
          @endauth
        </div>
      </div>
    @endforeach
  </div>
</div>


{{-- @auth
  <div class="product__wrapp">
    @foreach($categories as $category)
    <div class="product">
      <img class="product__item" src="{{ asset('/storage/catalog/' . $product->url ) }}" alt="{{ $product->url }}" />
      <p class="product__name">{{$product->name}}</p>
      <p class="product__description">{{$product->description_en}}</p>
      <p class="product__description">{{$product->description_es}}</p>
      <p class="product__description">{{$product->description_ru}}</p>
      <p class="product__price">{{$product->price}}</p>
      <p class="product__category">{{$product->category}}</p>
      <p class="product__collection">{{$product->collection}}</p>
      <form action="{{ route('deleteSlide', ['id' => $product->id]) }}">
        @csrf
        <button type="submit" class="delete">{{__('delete')}}</button>
        <button type="submit" class="edit">{{__('edit')}}</button>
      </form>
    </div>
    @endforeach
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
@endauth --}}
    
@endsection