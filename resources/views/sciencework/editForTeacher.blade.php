<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>  

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">

<div class="container">
<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>
                <div class="card-body">
                @if($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li >{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif 
                <form style='display:inline-block' action="{{url('/teacher/update/'.$sciencework->id) }}" method='POST' >
                                    {{method_field('PATCH')}}
                                    @csrf
                        <p>{{$sciencework->studname}} {{$sciencework->studsurname}} {{$sciencework->degree}} {{$sciencework->specialty}}</p>
                        <div class="form-group row">
                            <label for="topic" class="col-md-4 col-form-label text-md-right">{{ __('Topic') }}</label>
                            <div class="col-md-6">
                                <input id="topic" type="text"  name="topic" value="{{ $sciencework->topic }}"  required autocomplete="topic" autofocus>
                            </div>
                        </div>
                        <div class="form-group row">                        
                                 <label for="type" class="col-md-4 col-form-label text-md-right">{{ __("type") }}</label>
                                     <div class="col-md-6">
                                          <select class='type' id="type" name="type">
                                        @if($sciencework->type=='bachaelor coursework')
                                            <option selected="selected" value='bachaelor coursework'>bachaelor coursework</option>
                                            <option value='bachaelor dyploma'>bachaelor dyploma</option>
                                            <option value='major coursework'>major coursework</option>
                                            <option value='major dyploma'>major dyploma</option>
                                        @elseif($sciencework->type=='bachaelor dyploma')
                                            <option value='bachaelor coursework'>bachaelor coursework</option>
                                            <option selected="selected" value='bachaelor dyploma'>bachaelor dyploma</option>
                                            <option value='major coursework'>major coursework</option>
                                            <option value='major dyploma'>major dyploma</option>
                                        @elseif($sciencework->type=='major coursework')
                                            <option value='bachaelor coursework'>bachaelor coursework</option>
                                            <option value='bachaelor dyploma'>bachaelor dyploma</option>
                                            <option selected="selected" value='major coursework'>major coursework</option>
                                            <option value='major dyploma'>major dyploma</option>
                                        @elseif($sciencework->type=='major dyploma')
                                            <option value='bachaelor coursework'>bachaelor coursework</option>
                                            <option value='bachaelor dyploma'>bachaelor dyploma</option>
                                            <option value='major coursework'>major coursework</option>
                                            <option selected="selected" value='major dyploma'>major dyploma</option>
                                        @else
                                            <option value='bachaelor coursework'>bachaelor coursework</option>
                                            <option value='bachaelor dyploma'>bachaelor dyploma</option>
                                            <option value='major coursework'>major coursework</option>
                                            <option value='major dyploma'>major dyploma</option>
                                        @endif
                                         </select>
                                    </div>
                            </div>
                        <div class="form-group row">
                            <label for="presenting_date" class="col-md-4 col-form-label text-md-right">{{ __('presenting_date') }}</label>
                            <div class="col-md-6">
                            <input type="date" id="presenting_date" name="presenting_date" value="{{ $sciencework->presenting_date }}" min="1990-01-01" max="2040-12-31">
                            </div>
                        </div>   
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button  type="submit" class="btn btn-primary" >
                                    {{ __('Register') }}
                                </button>
                            </div>
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

<script type="text/javascript">
    var path = "{{ route('autocomplete') }}";
    $('input.typeahead').typeahead({
        source:  function (query, process) {
                return $.get(path, { query: query }, function (data) {
                    return process(data);
                });
        }
    });
    $('input.typeahead').change(function() {
    var current = $('input.typeahead').typeahead("getActive");
    if (current) {
        // document.getElementById("teacher").value = current.name;
        document.getElementById("teacher_id").value = current.id;
    }
    });
</script>


</html>