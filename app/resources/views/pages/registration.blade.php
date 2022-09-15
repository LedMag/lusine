@extends('main')

@section('name')
{{ __('registration') }}
@endsection

@section('content')

<div class="registration">
    <h2 class="registration__title">{{ __('registration') }}</h2>
    
    <form action="{{ route('registration.post') }}" method="POST" class="registration__form">
        @csrf
        <input name="name" type="text" class="registration__name" placeholder="{{__('name')}}">
        <input name="surname" type="text" class="registration__surname" placeholder="{{__('surname')}}">
        <input name="email" type="email" class="registration__email" placeholder="{{__('email')}}">
        <input name="confirmEmail" type="email" class="registration__email" placeholder="{{__('confirm.email')}}">
        <input name="password" type="password" class="registration__password" placeholder="{{__('password')}}">
        <input name="confirmPass" type="password" class="registration__password" placeholder="{{__('confirm.password')}}">
        <button type="submit" class="btn login-btn">{{__('send')}}</button>
    </form>
</div>
    
@endsection