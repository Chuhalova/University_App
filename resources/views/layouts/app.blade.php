<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="{{ asset('Eshopper/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('Eshopper/css/font-awesome.min.css ') }}" rel="stylesheet">
  <link href="{{ asset('Eshopper/css/prettyPhoto.css') }}" rel="stylesheet">
  <link href="{{ asset('Eshopper/css/price-range.css') }}" rel="stylesheet">
  <link href="{{ asset('Eshopper/css/animate.css') }}" rel="stylesheet">
  <link href="{{ asset('Eshopper/css/main.css') }}" rel="stylesheet">
  <link href="{{ asset('Eshopper/css/responsive.css') }}" rel="stylesheet">
  <link rel="shortcut icon" href="Eshopper/images/ico/favicon.ico') }}">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('Eshopper/images/ico/apple-touch-icon-144-precomposed.png') }}">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('Eshopper/images/ico/apple-touch-icon-114-precomposed.png') }}">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('Eshopper/images/ico/apple-touch-icon-72-precomposed.png') }}">
  <link rel="apple-touch-icon-precomposed" href="{{ asset('Eshopper/images/ico/apple-touch-icon-57-precomposed.png') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <script src="{{ asset('js/app.js') }}" defer></script>
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/customCss.css') }}" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div id="app">
    <div class="topnav" id="myTopnav">
      <a class="nav-link" href="{{ route('home') }}">{{ __('Додому') }}</a>
      @guest
      <a class="nav-link" href="{{ route('login') }}">{{ __('Залогінитись') }}</a>
      @if (Route::has('register'))
      <a class="nav-link" href="{{ route('register-as-student') }}">{{ __('Зареєструватись як студент') }}</a>
      <a class="nav-link" href="{{ route('register-as-teacher') }}">{{ __('Зареєструватись як викладач') }}</a>
      @endif
      @else
      <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
        {{ __('Вийти') }}
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
      <a class="nav-link" href="{{ route('profile') }}">{{ __('Профіль') }}</a>
      @role('student')
      <a class="nav-link" href="{{ route('show-for-student') }}">{{ __('Власні роботи') }}</a>
      <a class="nav-link" href="{{ route('show-topics-for-student') }}">{{ __('Вільні теми') }}</a>
      <a class="nav-link" href="{{ route('register-sciencework-as-student') }}">{{ __('Створити роботу') }}</a>
      @endrole
      @role('teacher')
      <a class="nav-link" href="{{ route('propose-topic-as-teacher') }}">{{ __('Створити тему') }}</a>
      <a class="nav-link" href="{{ route('get-topics-as-teacher') }}">{{ __('Створені теми') }}</a>
      <a class="nav-link" href="{{ route('show-for-teacher') }}">{{ __('Роботи') }}</a>
      @endrole
      @role('cathedraworker')
      <a class="nav-link" href="{{ route('show-for-cathedraworker') }}">{{ __('Всі роботи') }}</a>
      <a class="nav-link" href="{{ route('register-sciencework-as-cathedraworker') }}">{{ __('Створити роботу') }}</a>
      <a class="nav-link" href="{{ route('report') }}">{{ __('Загальний звіт') }}</a>
      <a class="nav-link" href="{{ route('application-report') }}">{{ __('Звіт по заявам') }}</a>
      <a class="nav-link" href="{{ route('works-report') }}">{{ __('Звіт по створеним роботам') }}</a>
      @endrole
      @role('superadmin')
      <a class="nav-link" href="{{ route('register-cathedraworker') }}">{{ __('Зареєструвати працівника кафедри') }}</a>
      @endrole
      @endguest
      <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
      </a>
    </div>
    <main class="py-4">
      @yield('content')
      <script type="text/javascript" src="{{asset('Eshopper/js/jquery.js')}}"></script>
      <script type="text/javascript" src="{{asset('Eshopper/js/bootstrap.min.js')}}"></script>
      <script src="{{asset('Eshopper/js/jquery.js')}}"></script>
      <script type="text/javascript">
        function myFunction() {
          var x = document.getElementById("myTopnav");
          if (x.className === "topnav") {
            x.className += " responsive";
          } else {
            x.className = "topnav";
          }
        }
      </script>
    </main>
  </div>
</body>
</html>