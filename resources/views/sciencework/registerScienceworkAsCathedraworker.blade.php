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
    <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
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
                        @endguest
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>
        <main class="py-4">
            <div id='register-cathedraworker' class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="shopper-info">
                            <div class="col-sm-12">
                                @if($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                @endif
                                <div class="contact-form">
                                    <h2 class="title text-center">Подати заявку на роботу</h2>
                                    <div class="status alert alert-success" style="display: none"></div>
                                    <form id='sub' method="POST" action="{{ route('add-sciencework-as-cathedraworker') }}">
                                        @csrf
                                        <div class="form-group col-md-12">
                                            <label for="topic">{{ __('Тема роботи') }}</label>
                                            <input class="form-control" placeholder="Тема роботи" id="topic" type="text" name="topic" value="{{ old('topic') }}" required autocomplete="topic" autofocus>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="type">{{ __("Тип роботи") }}</label>
                                            <select class="form-control" id="type" name="type">
                                                <option value='bachaelor coursework'>курсова робота / бакалавр</option>
                                                <option value='bachaelor dyploma'>дипломна робота / бакалавр</option>
                                                <option value='major coursework'>курсова робота / магістр</option>
                                                <option value='major dyploma'>дипломна робота / магістр</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="presenting_date">{{ __('Дата здачі роботи') }}</label>
                                            <input class="form-control" placeholder="Дата здачі роботи" type="date" id="presenting_date" name="presenting_date" value="2018-07-22" min="1990-01-01" max="2040-12-31">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="teacher">{{ __('Науковий керівник (будь-ласка здійсніть пошук за прізвищем викладача)') }}</label>
                                            <input class="form-control" required='required' placeholder="Науковий керівник" id="teacher" name="teacher" class="typeahead form-control" type="text">
                                            <input class="form-control" required='required' id="teacher_id" name="teacher_id" class="typeahead form-control" type="text" hidden>
                                            <div style="position:absolute;left:0;" class="col-md-12" id="teacher_list"></div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="student">{{ __('Студент (будь-ласка здійсніть пошук за прізвищем студента)') }}</label>
                                            <input class="form-control" required='required' placeholder="Студент" id="student" name="student" class="typeahead form-control" type="text">
                                            <input class="form-control" required='required' id="student_id" name="student_id" class="typeahead form-control" type="text" hidden>
                                            <div style="position:absolute;left:0;" class="col-md-12" id="student_list"></div>
                                        </div>
                                        <div style="align-content: center !important;text-align:center !important;" class="form-group col-md-12">
                                            <button style="margin:auto" type="submit" class="big-btn-in-form btn btn-primary">
                                                {{ __('Надіслати') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
    $(document).ready(function() {
        $('#teacher').on('keyup', function() {
            var query = $(this).val();
            $.ajax({
                url: "{{ route('autocomplete2') }}",
                type: "GET",
                data: {
                    'teacher': query
                },
                success: function(data) {
                    $('#teacher_list').html(data);
                }
            })
        });
        $(document).on('click', '.teacher_li', function() {
            var value = $(this).text();
            $('#teacher').val(value);
            $('#teacher_id').val($(this).attr("id"));
            $('#teacher_list').html("");
        });
        $('#student').on('keyup', function() {
            var query = $(this).val();
            $.ajax({
                url: "{{ route('autocomplete') }}",
                type: "GET",
                data: {
                    'student': query
                },
                success: function(data) {
                    $('#student_list').html(data);
                }
            })
        });
        $(document).on('click', '.student_li', function() {
            var value = $(this).text();
            $('#student').val(value);
            $('#student_id').val($(this).attr("id"));
            $('#student_list').html("");
        });
    });
    function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>
<script type="text/javascript" src="{{asset('Eshopper/js/jquery.js')}}"></script>
<script type="text/javascript" src="{{asset('Eshopper/js/bootstrap.min.js')}}"></script>
<script src="{{asset('Eshopper/js/jquery.js')}}"></script>
</html>