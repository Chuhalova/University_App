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
    <div id="app" style="position:relative">
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
        <div class="row" style="margin:0px !important">
            <div id='app-nav-block' class="checkout-options col-md-3 col-md-offset-0 col-sm-12 col-sm-offset-0">
                <ul class="nav">
                    <form style="margin-bottom:100px" action="{{url('/student/formulate-source/') }}" method='GET'>
                        {{method_field('GET')}}
                        @csrf
                        <div class="status alert alert-success" style="display: none"></div>
                        
                        <form>
                        <div class="form-group col-md-12">
                            <select class="form-control" name="select_source_type"  id="select_source_type">
                                 <option value="web-source">Електронне джерело</option>
                                 <option value="other-sources">Друковані джерела</option>
                            </select>
                        </div>
                        <div id='web-source-name-block' class="form-group col-md-12">
                            <label for="web-source-name">Назва роботи</label>
                            <input class="form-control @error('web-source-name') is-invalid @enderror" type="text" name="web-source-name" id="web-source-name" value="{{ old('web-source-name') }}"  autocomplete="web-source-name" autofocus>
                        </div>
                        <div id='web-source-authorname-block' class="form-group col-md-12">
                            <label for="web-source-authorname">Ім'я автора</label>
                            <input class="form-control @error('web-source-authorname') is-invalid @enderror" type="text" name="web-source-authorname" id="web-source-authorname" value="{{ old('web-source-authorname') }}"  autocomplete="web-source-authorname" autofocus>
                        </div>
                        <div id='web-source-fathername-block' class="form-group col-md-12">
                            <label for="web-source-fathername">По батькові автора</label>
                            <input class="form-control @error('web-source-fathername') is-invalid @enderror" type="text" name="web-source-fathername" id="web-source-fathername" value="{{ old('web-source-fathername') }}"  autocomplete="web-source-fathername" autofocus>
                        </div>
                        <div id='web-source-surname-block' class="form-group col-md-12">
                            <label for="web-source-surname">Прізвище автора</label>
                            <input class="form-control @error('web-source-surname') is-invalid @enderror" type="text" name="web-source-surname" id="web-source-surname" value="{{ old('web-source-surname') }}"  autocomplete="web-source-surname" autofocus>
                        </div>
                        <div id='web-source-link-block' class="form-group col-md-12">
                            <label for="web-source-link">Посилання на ресурс</label>
                            <input class="form-control @error('web-source-link') is-invalid @enderror" type="text" name="web-source-link" id="web-source-link" value="{{ old('web-source-link') }}"  autocomplete="web-source-link" autofocus>
                        </div>
                        <div style='display:none' id='source-surname-block' class="form-group col-md-12">
                            <label for="source-surname">Прізвище автора</label>
                            <input class="form-control @error('source-surname') is-invalid @enderror" type="text" name="source-surname" id="source-surname" value="{{ old('source-surname') }}"  autocomplete="source-surname" autofocus>
                        </div>
                        <div style='display:none' id='source-authorname-block' class="form-group col-md-12">
                            <label for="source-authorname">Ім'я автора</label>
                            <input class="form-control @error('source-authorname') is-invalid @enderror" type="text" name="source-authorname" id="source-authorname" value="{{ old('source-authorname') }}"  autocomplete="source-authorname" autofocus>
                        </div>
                        <div style='display:none' id='source-fathername-block' class="form-group col-md-12">
                            <label for="source-fathername">По батькові автора</label>
                            <input class="form-control @error('source-fathername') is-invalid @enderror" type="text" name="source-fathername" id="source-fathername" value="{{ old('source-fathername') }}"  autocomplete="source-fathername" autofocus>
                        </div>
                        <div style='display:none' id='source-name-block' class="form-group col-md-12">
                            <label for="source-name">Назва роботи</label>
                            <input class="form-control @error('source-name') is-invalid @enderror" type="text" name="source-name" id="source-name" value="{{ old('source-name') }}"  autocomplete="source-name" autofocus>
                        </div>
                        <div style='display:none' id='source-type-block' class="form-group col-md-12">
                            <label for="source-type">Тип роботи (підручник, книга...)</label>
                            <input class="form-control @error('source-type') is-invalid @enderror" type="text" name="source-type" id="source-type" value="{{ old('source-type') }}"  autocomplete="source-type" autofocus>
                        </div>
                        <div style='display:none' id='source-year-block' class="form-group col-md-12">
                            <label for="source-year">Рік видання</label>
                            <input class="form-control @error('source-year') is-invalid @enderror" type="text" name="source-year" id="source-year" value="{{ old('source-year') }}"  autocomplete="source-year" autofocus>
                        </div>
                        <div style='display:none' id='source-pages-block' class="form-group col-md-12">
                            <label for="source-pages">Сторінки</label>
                            <input class="form-control @error('source-pages') is-invalid @enderror" type="text" name="source-pages" id="source-pages" value="{{ old('source-pages') }}"  autocomplete="source-pages" autofocus>
                        </div>
                        <li>
                            <button type="submit" class="big-btn-in-form app-buttons btn btn-primary">
                                {{ __('клік') }}
                            </button>
                        </li>
                    </form>
                </ul>
            </div>
            <div class="col-md-9 col-sm-12 col-sm-offset-0 col-md-offset-0" >
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            </div>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).on("change", "#select_source_type", function (e) {
        if (this.value == 'web-source') {
            document.getElementById("web-source-name-block").style.display = "block";
            document.getElementById("web-source-authorname-block").style.display = "block";
            document.getElementById("web-source-fathername-block").style.display = "block";
            document.getElementById("web-source-surname-block").style.display = "block";
            document.getElementById("web-source-link-block").style.display = "block";
            document.getElementById("source-surname-block").style.display = "none";
            document.getElementById("source-authorname-block").style.display = "none";
            document.getElementById("source-fathername-block").style.display = "none";
            document.getElementById("source-name-block").style.display = "none";
            document.getElementById("source-type-block").style.display = "none";
            document.getElementById("source-year-block").style.display = "none";
            document.getElementById("source-pages-block").style.display = "none";
            } 
            else {
            document.getElementById("source-surname-block").style.display = "block";
            document.getElementById("source-authorname-block").style.display = "block";
            document.getElementById("source-fathername-block").style.display = "block";
            document.getElementById("source-name-block").style.display = "block";
            document.getElementById("source-type-block").style.display = "block";
            document.getElementById("source-year-block").style.display = "block";
            document.getElementById("source-pages-block").style.display = "block";
            document.getElementById("web-source-name-block").style.display = "none";
            document.getElementById("web-source-authorname-block").style.display = "none";
            document.getElementById("web-source-fathername-block").style.display = "none";
            document.getElementById("web-source-surname-block").style.display = "none";
            document.getElementById("web-source-link-block").style.display = "none";
            }
  });
    
    // '.tbl-content' consumed little space for vertical scrollbar, scrollbar width depend on browser/os/platfrom. Here calculate the scollbar width .
    $(window).on("load resize ", function() {
        var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
        $('.tbl-header').css({
            'padding-right': scrollWidth
        });
    }).resize();
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