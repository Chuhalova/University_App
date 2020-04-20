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
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/customCss.css') }}" rel="stylesheet">


<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">          
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="custom-menu-li nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Залогінитись') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="custom-menu-li nav-item">
                                    <a class="nav-link" href="{{ route('register-as-student') }}">{{ __('Зареєструватись як студент') }}</a>
                                </li>
                                <li class="custom-menu-li nav-item">
                                    <a class="nav-link" href="{{ route('register-as-teacher') }}">{{ __('Зареєструватись як викладач') }}</a>
                                </li>
                            @endif
                        @else  <li class="custom-menu-li nav-item">
                                   <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Вийти') }}
                                    </a>
                                   </li> 
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                            @role('student')
                            <li class="custom-menu-li nav-item">
                                    <a class="nav-link" href="{{ route('show-for-student') }}">{{ __('Власні роботи') }}</a>
                                </li>
                                <li class="custom-menu-li nav-item">
                                    <a class="nav-link" href="{{ route('show-topics-for-student') }}">{{ __('Вільні теми') }}</a>
                                </li>
                            <li class="custom-menu-li nav-item">
                                    <a class="nav-link" href="{{ route('register-sciencework-as-student') }}">{{ __('Створити роботу') }}</a>
                                </li>
                            @endrole
                            @role('teacher')
                            <li class='custom-menu-li nav-link'>
                                <a class="nav-link" href="{{ route('propose-topic-as-teacher') }}">{{ __('Створити тему') }}</a>
                            </li>
                            <li class='custom-menu-li nav-link'>
                                <a class="nav-link" href="{{ route('get-topics-as-teacher') }}">{{ __('Створені теми') }}</a>
                            </li>
                            <li class='custom-menu-li nav-link'>
                                <a class="nav-link" href="{{ route('show-for-teacher') }}">{{ __('Роботи') }}</a>
                            </li>
                            @endrole
                            @role('cathedraworker')
                            <li class='custom-menu-li nav-link'>
                                <a class="nav-link" href="{{ route('show-for-cathedraworker') }}">{{ __('Всі роботи') }}</a>
                            </li>
                            <li class='custom-menu-li nav-link'>
                                <a class="nav-link" href="{{ route('register-sciencework-as-cathedraworker') }}">{{ __('Створити роботу') }}</a>
                            </li>
                            <li class='custom-menu-li nav-link'>
                                <a class="nav-link" href="{{ route('report') }}">{{ __('Загальний звіт') }}</a>
                            </li>
                            <li class='custom-menu-li nav-link'>
                                <a class="nav-link" href="{{ route('application-report') }}">{{ __('Звіт по заявам') }}</a>
                            </li>
                            <li class='custom-menu-li nav-link'>
                                <a class="nav-link" href="{{ route('works-report') }}">{{ __('Звіт по створеним роботам') }}</a>
                            </li>
                            @endrole
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="shopper-info">
                        <p>{{ __('Подати заявку на роботу') }}</p>
                                @if($errors->any())
                                    <ul class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <li >{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif 
                                <form id='sub' method="POST" action="{{ route('add-sciencework-as-cathedraworker') }}">
                                    @csrf
                                    <label for="topic">{{ __('Тема роботи') }}</label>
                                    <input placeholder="Тема роботи" id="topic" type="text"  name="topic" value="{{ old('topic') }}" required autocomplete="topic" autofocus>                     
                                    <label for="type">{{ __("Тип роботи") }}</label>
                                    <select id="type" name="type">
                                        <option value='bachaelor coursework'>курсова робота / бакалавр</option>
                                        <option value='bachaelor dyploma'>дипломна робота / бакалавр</option>
                                        <option value='major coursework'>курсова робота / магістр</option>
                                        <option value='major dyploma'>дипломна робота / магістр</option>
                                    </select>
                                    <label for="presenting_date">{{ __('Дата здачі роботи') }}</label>
                                    <input placeholder="Дата здачі роботи" type="date" id="presenting_date" name="presenting_date" value="2018-07-22" min="1990-01-01" max="2040-12-31"> 
                                    <div class="col-lg-6">
                    <div class="form-group">
                    <label for="teacher">{{ __('Науковий керівник (будь-ласка здійсніть пошук за прізвищем викладача)') }}</label>
                                    <input required='required' placeholder="Науковий керівник" id="teacher" name="teacher" class="typeahead form-control" type="text">
                                    <input required='required' id="teacher_id" name="teacher_id" class="typeahead form-control" type="text" hidden>
                   
                    </div>
                    <div id="teacher_list"></div>                    
                </div>

                <div class="form-group">
                    <label for="student">{{ __('student (будь-ласка здійсніть пошук за прізвищем )') }}</label>
                                    <input required='required' placeholder="Student" id="student" name="student" class="typeahead form-control" type="text">
                                    <input required='required' id="student_id" name="student_id" class="typeahead form-control" type="text" hidden>
                   
                    </div>
                    <div id="student_list"></div>                    
                </div>


                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Надіслати') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#teacher').on('keyup',function() {
                    var query = $(this).val();
                    $.ajax({
                        url:"{{ route('autocomplete2') }}",
                        type:"GET",
                        data:{'teacher':query},
                        success:function (data) {
                            $('#teacher_list').html(data);
                        }
                    })
                });
                $(document).on('click', '.teacher_li', function(){
                    var value = $(this).text();
                    $('#teacher').val(value);
                    $('#teacher_id').val($(this).attr("id"));
                    $('#teacher_list').html("");
                });
                $('#student').on('keyup',function() {
                    var query = $(this).val();
                    $.ajax({
                        url:"{{ route('autocomplete') }}",
                        type:"GET",
                        data:{'student':query},
                        success:function (data) {
                            $('#student_list').html(data);
                        }
                    })
                });
                $(document).on('click', '.student_li', function(){
                    var value = $(this).text();
                    $('#student').val(value);
                    $('#student_id').val($(this).attr("id"));
                    $('#student_list').html("");
                });
            });
        </script>
    <script type="text/javascript" src="{{asset('Eshopper/js/jquery.js')}}"></script>
            <script type="text/javascript" src="{{asset('Eshopper/js/bootstrap.min.js')}}"></script>
            <script src="{{asset('Eshopper/js/jquery.js')}}"></script>
</html>