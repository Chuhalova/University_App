@extends('layouts.app')
@section('content')
<div id='post-topic-cont' class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="shopper-info">
                <div class="col-sm-12">
                    @if($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endif
                    <div class="contact-form">
                        <h2 class="title text-center">Запропонувати тему</h2>
                        <div class="status alert alert-success" style="display: none"></div>
                <form id='sub' method="POST" action="{{ route('post-topic-as-teacher') }}">
                                    @csrf
                            <div class="form-group col-md-12">
                                    
                            <label for="topic">{{ __('Тема роботи') }}</label>
                                    <input class="form-control" placeholder="Тема роботи" id="topic" type="text"  name="topic" value="{{ old('topic') }}" required autocomplete="topic" autofocus>                     
                                    </div>
                            <div class="form-group col-md-12">
                                   
                            <label for="type">{{ __("Тип роботи") }}</label>
                                    <select class="form-control" id="type" name="type">
                                        <option value='bachaelor coursework'>курсова робота / бакалавр</option>
                                        <option value='bachaelor dyploma'>дипломна робота / бакалавр</option>
                                        <option value='major coursework'>курсова робота / магістр</option>
                                        <option value='major dyploma'>дипломна робота / магістр</option>
                                    </select>
                            </div>
                            <div style="align-content: center !important;text-align:center !important;" class="form-group col-md-12">
                                    <button type="submit" class="big-btn-in-form btn btn-primary">
                                        {{ __('Надіслати') }}
                                    </button>
                            </div>
                                </form>
                                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection