@extends('layouts.app')
@section('content')
<div style='max-width:70vw;margin:50px auto 0 auto;'>
    @if($uploaded_work_comment!=''&& $workfile_check_status!='approved_file')
    <h2 style="margin-top:45px auto;text-align:left!important;" class="newtitle text-center">Коментар керівника:</h2>
    <h2 style="text-align:left!important;margin-bottom:45px;text-transform:none!important;" class="newtitle text-center">(внесіть правки згідно з вказівками керівника <br>та надішліть файл на повторну перевірку)</h2>
    <p id='work-review-comment'>
        {{$uploaded_work_comment}}
    </p>
    @endif
</div>
<div id='section-in-work-reviewing-page' class='student-work-reviewing-page' style='display:flex;justify-content:center;flex-direction:row;'>
    @if($workfile_check_status!='approved_file')
    <form style='display:inline-block;text-align:center;margin:25px;' enctype='multipart/form-data' action="{{url('/student/work-upload/') }}" method="post">
        {{method_field('PUT')}}
        {{ csrf_field() }}
        <h2 style="margin-top:45px auto;" class="newtitle text-center">Підвантажте файл з вашою роботою</h2>
        <h2 style="margin-bottom:45px;text-transform:none!important;" class="newtitle text-center">(підтримувані формати: doc,docx,odt,pdf,rtf,tex,txt,wpd)</h2>
        @if(count($errors))
        <div style="padding-right:0px!important;padding-left:0px!important;text-align:center!important;align-content:center!important;margin:0 auto; max-width:70%;" class="alert alert-danger" role="alert">
            <ul style="padding:0px!important;text-align:center!important;align-content:center!important;margin:0 auto!important;" class="error_container">
                @foreach($errors->all() as $key => $value)
                <li style="padding:0px!important;text-align:center!important;align-content:center!important;margin:0 auto!important;" class="error_li">{{ $value }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <input style="margin:45px auto;" type="file" class="input_change_avatar" name="uploaded_work_file" />
        <button type="submit" style="margin:auto;width:150px" class="btn btn-primary">Додати файл</button>
    </form>
    @endif
    <div style='display:inline-block;text-align:center;margin:25px;'>
        @if($file_exists==true)
        <form action="{{ url('/student/work-download') }}" method="GET">
            {{method_field('GET')}}
            @csrf
            <h2 style="margin-top:45px auto;" class="newtitle text-center">Натисність на іконку файлу для того,<br>щоб скачати файл.</h2>
            <button type="submit" id="button-file"></button>
        </form>
        @endif
        @if($file_or_note_exists==true&&$workfile_check_status!='approved_file')
        <form style="margin-top:10px !important;" action="{{url('/student/work-del/') }}" method="post">
            {{method_field('PUT')}}
            {{ csrf_field() }}
            <button type="submit" style="margin:10px auto; width:150px" class="btn btn-primary">Видалити файл</button>
        </form>
        @endif
    </div>
</div>
@endsection