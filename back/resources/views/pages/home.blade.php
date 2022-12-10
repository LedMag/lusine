@extends('main')

@section('name')
{{ __('home') }}
@endsection

@section('content')

@guest    
<div class="slider-wrapper theme-light">
  <div id="slider">
    @foreach($files as $file)
      <img class="slider-item" src="{{ asset('/storage/slider/' . $file ) }}" alt="{{ $file }}" />
    @endforeach
  </div>
</div>
@endguest

@auth
  <div class="slider__form-wrapp">
    @foreach($files as $file)
    <div class="slider-image__wrapper">
      <img class="slider-item" src="{{ asset('/storage/slider/' . $file ) }}" alt="{{ $file }}" />
      <form action="{{ route('deleteSlide', ['name' => $file]) }}">
        @csrf
        <button type="submit" class="delete slider-btn">{{__('delete')}}</button>
      </form>
    </div>
    @endforeach
    <form action="{{ route('addSlide') }}" method="POST" enctype="multipart/form-data" class="slider__form">
      @csrf
      <input name="image" type="file" class="slider__image">
      <button type="submit" class="btn input">{{__('send')}}</button>
    </form>
  </div>
@endauth

@endsection

