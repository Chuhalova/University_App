@extends('layouts.app')
@section('content')
<form style='display:inline-block' action="{{ url('/teacher/download-work/'.$sw_o->id) }}" method="GET">
    {{method_field('GET')}}
    @csrf
    <button type="submit" id="button-file"></button>
</form>
<form style='display:inline-block' action="{{ url('/teacher/add-work-comment/'.$sw_o->id) }}" method='POST'>
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
    <textarea required rows="5" cols="60" name="uploaded_work_comment"></textarea><br>
    <input type="submit" value="submit" />
</form>
@endsection