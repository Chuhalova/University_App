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
                                <option value="0">Оберіть тип джерела</option>
                                 <option value="web-source">Електронне джерело</option>
                                 <option value="other-sources">Друковані джерела</option>
                            </select>
                        </div>
                        <div style='display:none' id='web_source_name_block' class="form-group col-md-12">
                            <label for="web_source_name">Назва роботи</label>
                            <input class="form-control @error('web_source_name') is-invalid @enderror" type="text" name="web_source_name" id="web_source_name" value="{{ old('web_source_name') }}"  autocomplete="web_source_name" autofocus>
                        </div>
                        <div style='display:none' id='web_source_authorname_block' class="form-group col-md-12">
                            <label for="web_source_authorname">Ім'я автора</label>
                            <input class="form-control @error('web_source_authorname') is-invalid @enderror" type="text" name="web_source_authorname" id="web_source_authorname" value="{{ old('web_source_authorname') }}"  autocomplete="web_source_authorname" autofocus>
                        </div>
                        <div style='display:none' id='web_source_fathername_block' class="form-group col-md-12">
                            <label for="web_source_fathername">По батькові автора</label>
                            <input class="form-control @error('web_source_fathername') is-invalid @enderror" type="text" name="web_source_fathername" id="web_source_fathername" value="{{ old('web_source_fathername') }}"  autocomplete="web_source_fathername" autofocus>
                        </div>
                        <div style='display:none' id='web_source_surname_block' class="form-group col-md-12">
                            <label for="web_source_surname">Прізвище автора</label>
                            <input class="form-control @error('web_source_surname') is-invalid @enderror" type="text" name="web_source_surname" id="web_source_surname" value="{{ old('web_source_surname') }}"  autocomplete="web_source_surname" autofocus>
                        </div>
                        <div style='display:none' id='web_source_link_block' class="form-group col-md-12">
                            <label for="web_source_link">Посилання на ресурс</label>
                            <input class="form-control @error('web_source_link') is-invalid @enderror"  name="web_source_link" id="web_source_link" value="{{ old('web_source_link') }}"  autocomplete="web_source_link" autofocus>
                        </div>
                        <div style='display:none' id='source_surname_block' class="form-group col-md-12">
                            <label for="source_surname">Прізвище автора</label>
                            <input class="form-control @error('source_surname') is-invalid @enderror" type="text" name="source_surname" id="source_surname" value="{{ old('source_surname') }}"  autocomplete="source_surname" autofocus>
                        </div>
                        <div style='display:none' id='source_authorname_block' class="form-group col-md-12">
                            <label for="source_authorname">Ім'я автора</label>
                            <input class="form-control @error('source_authorname') is-invalid @enderror" type="text" name="source_authorname" id="source_authorname" value="{{ old('source_authorname') }}"  autocomplete="source_authorname" autofocus>
                        </div>
                        <div style='display:none' id='source_fathername_block' class="form-group col-md-12">
                            <label for="source_fathername">По батькові автора</label>
                            <input class="form-control @error('source_fathername') is-invalid @enderror" type="text" name="source_fathername" id="source_fathername" value="{{ old('source_fathername') }}"  autocomplete="source_fathername" autofocus>
                        </div>
                        <div style='display:none' id='source_name_block' class="form-group col-md-12">
                            <label for="source_name">Назва роботи</label>
                            <input class="form-control @error('source_name') is-invalid @enderror" type="text" name="source_name" id="source_name" value="{{ old('source_name') }}"  autocomplete="source_name" autofocus>
                        </div>
                        <div style='display:none' id='source_type_block' class="form-group col-md-12">
                            <label for="source_type">Тип роботи (підручник, книга...)</label>
                            <input class="form-control @error('source_type') is-invalid @enderror" type="text" name="source_type" id="source_type" value="{{ old('source_type') }}"  autocomplete="source_type" autofocus>
                        </div>
                        <div style='display:none' id='source_year_block' class="form-group col-md-12">
                            <label for="source_year">Рік видання</label>
                            <input class="form-control @error('source_year') is-invalid @enderror" type="text" name="source_year" id="source_year" value="{{ old('source_year') }}"  autocomplete="source_year" autofocus>
                        </div>
                        <div style='display:none' id='source_pages_block' class="form-group col-md-12">
                            <label for="source_pages">Сторінки</label>
                            <input class="form-control @error('source_pages') is-invalid @enderror"  name="source_pages" id="source_pages" value="{{ old('source_pages') }}"  autocomplete="source_pages" autofocus>
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
            @if($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
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
        switch (this.value) {
            case 'other-sources':
            document.getElementById("source_surname_block").style.display = "block";
            document.getElementById("source_authorname_block").style.display = "block";
            document.getElementById("source_fathername_block").style.display = "block";
            document.getElementById("source_name_block").style.display = "block";
            document.getElementById("source_type_block").style.display = "block";
            document.getElementById("source_year_block").style.display = "block";
            document.getElementById("source_pages_block").style.display = "block";
            document.getElementById("web_source_name_block").style.display = "none";
            document.getElementById("web_source_authorname_block").style.display = "none";
            document.getElementById("web_source_fathername_block").style.display = "none";
            document.getElementById("web_source_surname_block").style.display = "none";
            document.getElementById("web_source_link_block").style.display = "none";
        break;
        case 'web-source':
            document.getElementById("web_source_name_block").style.display = "block";
            document.getElementById("web_source_authorname_block").style.display = "block";
            document.getElementById("web_source_fathername_block").style.display = "block";
            document.getElementById("web_source_surname_block").style.display = "block";
            document.getElementById("web_source_link_block").style.display = "block";
            document.getElementById("source_surname_block").style.display = "none";
            document.getElementById("source_authorname_block").style.display = "none";
            document.getElementById("source_fathername_block").style.display = "none";
            document.getElementById("source_name_block").style.display = "none";
            document.getElementById("source_type_block").style.display = "none";
            document.getElementById("source_year_block").style.display = "none";
            document.getElementById("source_pages_block").style.display = "none";
        break;
        default:
            document.getElementById("source_surname_block").style.display = "none";
            document.getElementById("source_authorname_block").style.display = "none";
            document.getElementById("source_fathername_block").style.display = "none";
            document.getElementById("source_name_block").style.display = "none";
            document.getElementById("source_type_block").style.display = "none";
            document.getElementById("source_year_block").style.display = "none";
            document.getElementById("source_pages_block").style.display = "none";
            document.getElementById("web_source_name_block").style.display = "none";
            document.getElementById("web_source_authorname_block").style.display = "none";
            document.getElementById("web_source_fathername_block").style.display = "none";
            document.getElementById("web_source_surname_block").style.display = "none";
            document.getElementById("web_source_link_block").style.display = "none";
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