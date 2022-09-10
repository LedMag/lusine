@extends('main')

@section('name')
{{ __('registration') }}
@endsection

@section('content')

<div class="registration">
    <h2 class="registration__title">{{ __('registration') }}</h2>
    
    <form action="" method="POST" class="registration__form">
        <input name="name" type="text" class="registration__name" placeholder="Name">
        <input name="surname" type="text" class="registration__surname" placeholder="Surname">
        <input name="email" type="email" class="registration__email" placeholder="Email">
        <input name="password" type="password" class="registration__password" placeholder="Password">
        <input name="confirm-pass" type="password" class="registration__password" placeholder="Confirm Password">
    </form>
</div>
    
@endsection