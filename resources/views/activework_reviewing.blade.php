@extends('layouts.app')
@section('content')
@if(count($errors))
<div class="alert alert-danger" role="alert">
    <ul class="error_container">
        @foreach($errors->all() as $key => $value)
        <li class="error_li">{{ $value }}</li>
        @endforeach
    </ul>
</div>
@endif
@if($sw->workfile_check_status=='unchecked' && $sw->uploaded_work_file==null)
<form enctype='multipart/form-data' action="{{url('/student/work-upload/') }}" method="post">
    {{method_field('PUT')}}
    {{ csrf_field() }}
    <input type="file" class="input_change_avatar" name="uploaded_work_file" />
    <button type="submit" style="margin:auto;width:150px" class="btn btn-primary">Додати файл</button>
</form>
@endif
@if($file_or_note_exists==true)
<form style="margin-top:10px !important;" action="{{url('/student/work-del/') }}" method="post">
    {{method_field('PUT')}}
    {{ csrf_field() }}
    <button type="submit" style="margin:auto;width:150px" class="btn btn-primary">Видалити файл</button>
</form>
@endif
@if($file_exists==true)
<form style='display:inline-block' action="{{ url('/student/work-download') }}" method="GET">
    {{method_field('GET')}}
    @csrf
    <button type="submit" id="button-file"></button>

</form>
@endif
@if($uploaded_work_comment!='')
{{$uploaded_work_comment}}
@endif
@endsection