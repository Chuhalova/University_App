@extends('layouts.app')
@section('content')

<form style='display:inline-block' action="{{ url('/teacher/download-work/'.$sw_o->id) }}" method="GET">
    {{method_field('GET')}}
    @csrf
    <button type="submit" id="button-file"></button>

</form>
@endsection