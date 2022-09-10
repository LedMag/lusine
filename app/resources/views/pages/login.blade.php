@extends('main')

@section('name')
{{ __('login') }}
@endsection

@section('content')

<div class="login">    
    <h2 class="login__title">{{ __('login') }}</h2>

    <form action="" method="POST" class="login__form">
        <input nmae="email" type="email" class="login__email" placeholder="Email">
        <input name="password" type="password" class="login__password" placeholder="Password">
    </form>
</div>
    
@endsection