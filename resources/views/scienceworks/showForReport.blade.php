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
                        @else <li class="custom-menu-li nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
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
        <div id='report-row' class="row">
            <div id='report-block' class="form-two checkout-options col-md-3 col-md-offset-0 col-sm-12 col-sm-offset-0">
          
                 
                                    <form id='report-form' action="{{url('/cathedraworker/report/') }}" method='GET' >
                                    {{method_field('GET')}}
                                    @csrf
                                    <input  placeholder="Пошук викладача за прізвищем" id="teacher" name="teacher" class="typeahead form-control" type="text">
                                    <div style="position:absolute;left:0;top:80px" class="col-md-12" id="teacher_list"></div>
                                    <select class="form-control" name="group" id="group">
                                        <option id='checked-option'>Вибрати групу</option>
                                    </select>
                                    <input id="teacher_id" name="teacher_id" class="typeahead form-control" type="text" hidden>
                                    <input id="group_year" name="group_year" class="typeahead form-control" type="text" hidden>
                                    <input id="group_group" name="group_group" class="typeahead form-control" type="text" hidden>
                                    <input id="group_specialty" name="group_specialty" class="typeahead form-control" type="text" hidden>
                                    <button  type="submit" class="btn btn-primary" >
                                    {{ __('Звіт') }}
                                </button>  
                                </form>
                                   
                                    <div id="group_list"></div>
                                </div>
         
            <div id='teachers-table-container' class="col-md-9 col-sm-12 col-sm-offset-0 col-md-offset-0">
                <div id='teachers-table' class=" table-wrapper">
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
                                    Наявна
                                    @else
                                    Відсутня
                                    @endif
                        </td>
                        <td>{{$sw->name .' '. $sw->surname .', '. $sw->scrank .', '. $sw->degree}}</td>
                        <td>{{$sw->sname .' '. $sw->ssurname .', '.implode('',array_diff_assoc(str_split(ucwords($sw->specialty)),str_split(strtolower($sw->specialty)))).''.$sw->year.'-'.$sw->group}}</td>
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
     $(document).ready(function () {
                $('#teacher').on('keyup',function() {
                    var query = $(this).val();
                    $.ajax({
                        url:"{{ route('autocomplete3') }}",
                        type:"GET",
                        data:{'teacher':query},
                        success:function (data) {
                            $('#teacher_list').html(data);
                        }
                    })
                });
                $(document).ready(function() {
                    $.get("/autocompleteGroup", function(data, status){           
                        data.forEach(function(item) {
                            var items = new Array();
                            var items = [item.year, item.group, item.specialty]; 
                                $('#group').append(`<option value="`+items+`">` + item.name +`</option>`);
                            console.log(items);
                        });
                    });
                });
                $(document).on('click', '.teacher_li', function(){
                    var value = $(this).text();
                    $('#teacher').val(value);
                    $('#teacher_id').val($(this).attr("id"));
                    $('#teacher_list').html("");
                });
                var eSelect = document.getElementById('group');
                eSelect.onchange = function() {
                    var data = eSelect.options[eSelect.selectedIndex].value;
                    var dataArr = data.split(',');
                    $('#group_year').val(dataArr[0]);
                    $('#group_group').val(dataArr[1]);
                    $('#group_specialty').val(dataArr[2]);
                }
            });
        </script>
    <script type="text/javascript" src="{{asset('Eshopper/js/jquery.js')}}"></script>
            <script type="text/javascript" src="{{asset('Eshopper/js/bootstrap.min.js')}}"></script>
            <script src="{{asset('Eshopper/js/jquery.js')}}"></script>
</html>

