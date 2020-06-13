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



    <div id='teachers-table-container' class="col-md-9 col-sm-12 col-sm-offset-0 col-md-offset-0">

        <div id='teachers-table' class=" table-wrapper">
            <p style="text-align: center;">
                <b>

                    _______________________Протокол №_______________________
                    <br>
                    засідання кафедри {{$cathedra_id}}
                    <br>
                    факультету інформаційних технологій
                    <br>
                    Київського національного університету імені Тараса Шевченка
                    <br>
                    від {{$time}}
                </b>
            </p>
            <p>
                <b>ПРИСУТНІ:</b>
                <br>
                <br>
                <br>
            </p>
            <p style="text-align:right;">
                <b>
                    Всього науково-педагогічних працівників кафедри –&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;, інших -&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <br>
                    Присутні члени кафедри –&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;, інших -&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </b>
            </p>
            <p>
                <b>ПОРЯДОК ДЕННИЙ:</b>
                <br>
                Про затвердження тем випускних кваліфікаційних
                @if($degree=='bachelor')
                бакалаврських
                @elseif($degree=="master")
                магістерських
                @endif
                робіт на {{$start}} - {{$end}} н.р. для
                студентів {{$year}} курсу (
                @if($degree=='bachelor')
                бакалавр
                @elseif($degree=="master")
                магістр
                @endif
                ) спеціальності {{$specialty}}
            </p>
            <p>
                <b>
                    СЛУХАЛИ:
                </b>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                – оприлюднив основні вимоги до написання, оформлення та захисту КВАЛІФІКАЦІЙНА @if($degree=='bachelor')
                БАКАЛАВРСЬКА
                @elseif($degree=="master")
                МАГІСТЕРСЬКА
                @endif РОБОТА
                студентів {{$year}} (
                @if($degree=='bachelor')
                бакалавр
                @elseif($degree=="master")
                магістр
                @endif
                ) спеціальності {{$specialty}}. Пропонуються такі теми
                @if(($degree=='bachelor' && $year=='3') || ($degree=='master' && $year=='1'))
                курсових
                @elseif(($degree=='bachelor' && $year=='4') || ($degree=='master' && $year=='2')))
                дипломних
                @endif
                проектів:

            </p>
            <p style='text-align:center'>
                <b>


                    Перелік тем
                    @if(($degree=='bachelor' && $year=='3') || ($degree=='master' && $year=='1'))
                    курсових
                    @elseif(($degree=='bachelor' && $year=='4') || ($degree=='master' && $year=='2')))
                    дипломних
                    @endif
                    робіт (
                    @if($degree=='bachelor')
                    бакалаври
                    @elseif($degree=="master")
                    магістри
                    @endif
                    ) 2019-2020 рр
                </b>
            </p>

            <table class="fl-table">
                <thead class="thead-light">
                    <tr>
                        <th>Група</th>
                        <th scope="col">ПІБ</th>
                        <th scope="col">Керівник</th>
                        <th scope="col">Тема</th>


                    </tr>
                </thead>
                <tbody>
                    @foreach($sws as $sw)
                    <tr>
                        <th>
                            {{$sw->specialty_abbr. '-' . $sw->year . '' . $sw->group}}
                        </th>
                        <td>{{$sw->sname .' '. $sw->ssurname}}</td>
                        <td>{{$sw->surname}}</td>

                        <th scope="row">{{$sw->topic}}</th>



                    </tr>
                    @endforeach
                </tbody>
            </table>
            <p>
                <b>

                    <br>
                    РЕЗУЛЬТАТИ ВІДКРИТОГО ГОЛОСУВАННЯ:
                </b>
                <b>

                    <br>
                    «За»</b> - &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;;
                <br><b>«Проти»</b> - &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;;
                <br><b>«Утримались» </b>- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;;

                <br><b>УХВАЛИЛИ</b>: за результатами відкритого голосування (за – &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;, проти –&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;, утримались – &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;) затвердити запропоновані теми @if(($degree=='bachelor' && $year=='3') || ($degree=='master' && $year=='1'))
                курсових
                @elseif(($degree=='bachelor' && $year=='4') || ($degree=='master' && $year=='2')))
                дипломних
                @endif
                проектів {{$year}} курсу спеціальності {{$specialty}}.

            </p>
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