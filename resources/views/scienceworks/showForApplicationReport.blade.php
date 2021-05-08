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
                                    <a class="nav-link" href="{{ route('profile') }}">{{ __('Профіль') }}</a>
                                    @role('student')
                                    <a class="nav-link" href="{{ route('show-for-student') }}">{{ __('Власні роботи') }}</a>
                                    <a class="nav-link" href="{{ route('show-topics-for-student') }}">{{ __('Вільні теми') }}</a>
                                    <a class="nav-link" href="{{ route('register-sciencework-as-student') }}">{{ __('Створити роботу') }}</a>
                                    <a class="nav-link" href="{{ route('source-tool') }}">{{ __('Форматування джерел') }}</a>
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
                    <form action="{{url('/cathedraworker/application-report/') }}" method='GET'>
                        {{method_field('GET')}}
                        @csrf
                        @if($checked==false)
                        <li>
                            <label><input name="application" id="all" value='all' checked type="radio">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;"> Усі роботи</font>
                                </font>
                            </label>
                        </li>
                        <li>
                            <label><input name="application" id="without" value='without' type="radio">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;"> Роботи без заяв</font>
                                </font>
                            </label>
                        </li>
                        @else
                        <li>
                            <label><input name="application" id="all" value='all' type="radio">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;"> Усі роботи</font>
                                </font>
                            </label>
                        </li>
                        <li>
                            <label><input name="application" id="without" value='without' checked type="radio">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;"> Роботи без заяв</font>
                                </font>
                            </label>
                        </li>
                        @endif
                        <li>
                            <button type="submit" class="big-btn-in-form app-buttons btn btn-primary">
                                {{ __('Звіт') }}
                            </button>
                        </li>
                    </form>
                    <form action="{{url('/cathedraworker/app-send-letters/')}}" method='GET'>
                        {{method_field('GET')}}
                        @csrf
                        <li>
                            <button type="submit" class="big-btn-in-form app-buttons btn btn-primary">
                                {{ __('Розіслати листи') }}
                            </button>
                        </li>
                    </form>
                </ul>
            </div>
            <div class="col-md-9 col-sm-12 col-sm-offset-0 col-md-offset-0" >
                <div id='teachers-table' class=" table-wrapper" >
                    <table class="fl-table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Назва</th>
                                <th scope="col">Тип</th>
                                <th scope="col">Дата захисту</th>
                                <th scope="col">Статус</th>
                                <th scope="col">Наявність заяви</th>
                                <th scope="col">Викладач</th>
                                <th scope="col">Студент</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sws as $sw)
                            <tr>
                                <th scope="row">{{$sw->topic}}</th>
                                <td>
                                    @if($sw->type=='bachaelor coursework')
                                    курсова робота / бакалавр
                                    @elseif($sw->type=='major coursework')
                                    курсова робота / магістр
                                    @elseif($sw->type=='bachaelor dyploma')
                                    дипломна робота / бакалавр
                                    @elseif($sw->type=='major dyploma')
                                    дипломна робота / магістр
                                    @endif
                                </td>
                                <td>{{$sw->presenting_date}}</td>
                                <td>
                                    @if($sw->status=='active')
                                    активна
                                    @endif
                                </td>
                                <td>
                                    @if($sw->application==0)
                                    Відсутня
                                    @else
                                    Наявна
                                    @endif
                                </td>
                                <td>{{$sw->name .' '. $sw->surname .' , '. $sw->scrank .' , '. $sw->degree}}</td>
                                 <td>{{$sw->sname .' '. $sw->ssurname .', '.$sw->specialty_abbr. '-' . $sw->year . '' . $sw->group}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript">
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