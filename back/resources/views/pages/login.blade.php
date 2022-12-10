@extends('main')

@section('name')
{{ __('login') }}
@endsection

@section('content')

<div class="login">    
    <h2 class="login__title">{{ __('login') }}</h2>

    <form action="{{ route('login.post') }}" method="POST" class="login__form">
        @csrf
        <input name="email" type="email" class="login__email" placeholder="{{__('email')}}">
        <input name="password" type="password" class="login__password" placeholder="{{__('password')}}">
        <button type="submit" class="btn">{{__('send')}}</button>
    </form>
</div>
    
@endsection