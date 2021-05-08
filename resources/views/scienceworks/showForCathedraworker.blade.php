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
        <div id='works-table' class="table-wrapper">
            <table class="fl-table">
                <thead>
                    <tr>
                        <th scope="col">Тема</th>
                        <th scope="col">Тип</th>
                        <th scope="col">Дата захисту</th>
                        <th scope="col">Статус</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col" id='high-th'></th>
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
                            @if($sw->status=='approved_by_teacher')
                            схвалена викладачем
                            @elseif($sw->status=='active')
                            активна
                            @endif
                        </td>
                        @if($sw->status=="approved_by_teacher")
                        <td>
                            <form style='display:inline-block' action="{{url('/cathedraworker/change-status/'.$sw->id) }}" method='POST'>
                                {{method_field('PATCH')}}
                                @csrf
                                <button type="submit" style="margin:auto;width:150px" class="btn btn-primary">Активувати</button>
                            </form>
                        </td>
                        <td>
                            <form style='display:inline-block' action="{{url('/cathedraworker/edit/'.$sw->id) }}" method='GET'>
                                {{method_field('GET')}}
                                @csrf
                                <button type="submit" style="margin:auto;width:150px" class="btn btn-primary">Редагувати</button>
                            </form>
                        </td>
                        <td id='high-td'>
                            <form style='display:inline-block' action="{{url('/cathedraworker/disapprove/'.$sw->id) }}" method='POST'>
                                {{method_field('PATCH')}}
                                @csrf
                                <select required='required' name="who" id="who">
                                    <option value="">Кому?</option>
                                    <option value="student">студенту</option>
                                    <option value="teacher">викладачу</option>
                                </select>
                                <input placeholder="Коментарій" id="comment" type="text" name="comment" value="{{ old('comment') }}" required autocomplete="comment" autofocus>
                                <button type="submit" style="margin:auto;width:150px" class="btn btn-primary">Повернути</button>
                            </form>
                        </td>
                        @elseif($sw->status=="active")
                        <td>
                            <form style='display:inline-block' action="{{url('/cathedraworker/change-status/'.$sw->id) }}" method='POST'>
                                {{method_field('PATCH')}}
                                @csrf
                                <button type="submit" style="margin:auto;width:150px" class="btn btn-primary">Деактивувати</button>
                            </form>
                        </td>
                        @if($sw->application==false)
                        <td>
                            <form style='display:inline-block' action="{{url('/cathedraworker/add-application/'.$sw->id) }}" method='POST'>
                                {{method_field('PATCH')}}
                                @csrf
                                <button type="submit" style="margin:auto;width:150px" class="btn btn-primary">Заяву пренесено</button>
                            </form>
                        </td>
                        <td id='high-td'>
                        </td>
                        @else
                        <td>
                        </td>
                        <td id='high-td'>
                        </td>
                        @endif
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;margin: auto;">
            {!! $sws->links()!!}
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