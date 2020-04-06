<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="col-md-3 form-group">
                            <form action="{{url('/cathedraworker/application-report/') }}" method='GET'>
                                {{method_field('GET')}}
                                @csrf
                                <label for="all">All</label>
                                @if($checked==false)
                                <input type="radio" name="application" id="all" value='all' checked>
                                <label for="without">Without</label>
                                <input type="radio" name="application" id="without" value='without'>
                                @else
                                <input type="radio" name="application" id="all" value='all'>
                                <label for="without">Without</label>
                                <input type="radio" name="application" id="without" value='without' checked>
                                @endif
                                <button type="submit" class="btn btn-primary">
                                    {{ __('report') }}
                                </button>
                            </form>
                        </div>
                        <div class="col-md-9 card">
                            <div class="card-header"></div>
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">topic</th>
                                        <th scope="col">type</th>
                                        <th scope="col">presenting_date</th>
                                        <th scope="col">status</th>
                                        <th scope="col">application</th>
                                        <th scope="col">teacher</th>
                                        <th scope="col">student</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sws as $sw)
                                    <tr>
                                        <th scope="row">{{$sw->topic}}</th>
                                        <td>{{$sw->type}}</td>
                                        <td>{{$sw->presenting_date}}</td>
                                        <td>{{$sw->status}}</td>
                                        <td>{{$sw->application}}</td>
                                        <td>{{$sw->name .' '. $sw->surname .' '. $sw->scrank .' '. $sw->degree}}</td>
                                        <td>{{$sw->sname .' '. $sw->ssurname .' '.implode('',array_diff_assoc(str_split(ucwords($sw->specialty)),str_split(strtolower($sw->specialty)))).''.$sw->year.'-'.$sw->group}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{asset('Eshopper/js/bootstrap.min.js')}}"></script>
<script src="{{asset('Eshopper/js/jquery.js')}}"></script>
</html>