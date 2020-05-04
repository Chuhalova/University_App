@extends('layouts.app')
@section('content')
<div class="container">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <ul id='alert-for-logined-users' class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 alert alert-danger">
        <li>
            <h4> {{$person->surname . ' ' . $person->name}}, Ви здійснили успішний вхід на сайт.</h4>
        </li>
    </ul>
    <div id='homapage-image' class='col-md-12'>
        <img src="{{ asset('unnamed.png')}}">
    </div>
</div>
@endsection