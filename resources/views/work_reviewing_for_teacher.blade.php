@extends('layouts.app')
@section('content')
<div id='section-in-work-reviewing-page' class='row' style='margin:0 !important;'>
        <form class='col-md-6 col-xs-12' style='display:inline-block;text-align:center;' action="{{ url('/teacher/download-work/'.$sw_o->id) }}" method="GET">
            {{method_field('GET')}}
            @csrf
            <div style="height:150px;margin-top:20px;">
            <button  type="submit" id="button-file"></button>
        </div>

            <h2 style="margin:45px auto;" class="newtitle text-center">Натисність на іконку файлу для того,<br>щоб скачати файл, наданий студентом.</h2>
        </form>
        <form class='col-md-6 col-xs-12' style='text-align:center;display:inline-block;' action="{{ url('/teacher/add-work-comment/'.$sw_o->id) }}" method='POST'>
            {{method_field('PATCH')}}
            {{ csrf_field() }}
            @if(count($errors))
            <div class="alert alert-danger" role="alert">
                <ul class="error_container">
                    @foreach($errors->all() as $key => $value)
                    <li class="error_li">{{ $value }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <label for="uploaded_work_comment"></label>
            <textarea required style='height:150px' cols="60" name="uploaded_work_comment"></textarea><br>
            <button type="submit" style="margin:25px auto;" class="btn btn-primary">Надіслати на <br> виправлення</button>
        </form>
</div>
@endsection