@extends('layouts.app')
@section('content')
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
                <form id='sub' method="POST" action="{{ route('post-topic-as-teacher') }}">
                                    @csrf
                                    <label for="topic">{{ __('Тема роботи') }}</label>
                                    <input placeholder="Тема роботи" id="topic" type="text"  name="topic" value="{{ old('topic') }}" required autocomplete="topic" autofocus>                     
                                    <label for="type">{{ __("Тип роботи") }}</label>
                                    <select id="type" name="type">
                                        <option value='bachaelor coursework'>курсова робота / бакалавр</option>
                                        <option value='bachaelor dyploma'>дипломна робота / бакалавр</option>
                                        <option value='major coursework'>курсова робота / магістр</option>
                                        <option value='major dyploma'>дипломна робота / магістр</option>
                                    </select>
                                    <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Надіслати') }}
                                    </button>
                                </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
