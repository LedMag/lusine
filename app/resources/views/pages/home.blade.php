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

@endsection

