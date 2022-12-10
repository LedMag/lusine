<header class="header">
    <div class="header__top">
      <a class="header__logo" data-url="home">
        <img src="/images/logo.png" alt="Logo" class="header__img">
      </a>
      <div id="langs" class="header__langs">
        <a href="{{ route('language', 'en') }}" class="header__lang {{ app()->getLocale() === 'en' ? 'activeLang' : '' }}">en</a>
        <a href="{{ route('language', 'es') }}" class="header__lang {{ app()->getLocale() === 'es' ? 'activeLang' : '' }}">es</a>
        <a href="{{ route('language', 'ru') }}" class="header__lang {{ app()->getLocale() === 'ru' ? 'activeLang' : '' }}">ru</a>
      </div>
    </div>  
    <nav class="header__nav spr">
      <ul class="header__menu spr-inner">
        <li class="header__item">
          <a href="{{ route('home', app()->getLocale() ) }}" class="header__link {{ Route::is('home') ? 'active__link' : '' }}">{{ __("home") }}</a>
        </li>
        <li class="header__item">
          <a href="{{ route('catalog', app()->getLocale() ) }}" class="header__link {{ Route::is('catalog') ? 'active__link' : '' }}">{{ __("catalog") }}</a>
        </li>
        <li class="header__item">
          <a href="{{ route('about', app()->getLocale() ) }}" class="header__link {{ Route::is('about') ? 'active__link' : '' }}">{{ __("about") }}</a>
        </li>
        <li class="header__item">
          <a href="{{ route('contacts', app()->getLocale() ) }}" class="header__link {{ Route::is('contacts') ? 'active__link' : '' }}">{{ __("contacts") }}</a>
        </li>
        @auth
        <li class="header__item">
          <a href="{{ route('logout', app()->getLocale() ) }}" class="header__link {{ Route::is('admin.logout') ? 'active__link' : '' }}">{{ __(">") }}</a>
        </li>
        @endauth
      </ul>
    </nav>
</header>