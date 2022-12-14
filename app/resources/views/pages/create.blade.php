@extends('main')

@section('name')
{{ __('create') }}
@endsection

@section('content')

@auth
  <div class="show__content">
    <div class="image__wrapper">
        <img id="imageShow" src="" alt="">
    </div>
    <form action="{{ route('create.product.post') }}" method="POST" enctype="multipart/form-data" class="product__form">
        @csrf
        <input id="inputImage" name="image" type="file" class="input">
        <input name="name" type="text" class="input" placeholder="{{__('name')}}">
        <textarea 
            name="description_en" 
            type="text" 
            class="input description"
            placeholder="{{__('description.en')}}"
        ></textarea>
        <textarea 
            name="description_es" 
            type="text" 
            class="input description" 
            placeholder="{{__('description.es')}}"
        ></textarea>
        <textarea 
            name="description_ru" 
            type="text" 
            class="input description" 
            placeholder="{{__('description.ru')}}"
        ></textarea>
        <input name="price" type="number" class="input" placeholder="{{__('price')}}">
        <select name="category" class="input">
            {{-- <option value="" disabled selected hidden>{{__('category')}}</option> --}}
            @foreach($categories as $category)
            <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
        <select name="collection" class="input">
            {{-- <option value="" disabled selected hidden>{{__('collection')}}</option> --}}
            @foreach($collections as $collection)
            <option value="{{$collection->id}}">{{$collection->name}}</option>
            @endforeach
        </select>
        <button type="submit" class="btn input">{{__('send')}}</button>
    </form>
  </div>
@endauth
    
@endsection