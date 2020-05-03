@extends('layouts.app')
@section('content')
<div id='edit-sw-teacher' class="container">
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
                        <h2 class="title text-center">Відредагувати роботу</h2>
                        <div class="status alert alert-success" style="display: none"></div>
                        <form  action="{{url('/teacher/update/'.$sw->id) }}" method='POST'>
                            {{method_field('PATCH')}}
                            @csrf
                            <div class="form-group col-md-12">
                                <label for="topic">{{ __('Назва') }}</label>
                                <input class="form-control" id="topic" type="text" name="topic" value="{{ $sw->topic }}" required autocomplete="topic" autofocus>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="type">{{ __("Тип") }}</label>
                                <select class="form-control" class='type' id="type" name="type">
                                    @if($sw->type=='bachaelor coursework')
                                    <option selected="selected" value='bachaelor coursework'>курсова робота / бакалавр</option>
                                    <option value='bachaelor dyploma'>дипломна робота / бакалавр</option>
                                    <option value='major coursework'>курсова робота / магістр</option>
                                    <option value='major dyploma'>дипломна робота / магістр</option>
                                    @elseif($sw->type=='bachaelor dyploma')
                                    <option value='bachaelor coursework'>курсова робота / бакалавр</option>
                                    <option selected="selected" value='bachaelor dyploma'>дипломна робота / бакалавр</option>
                                    <option value='major coursework'>курсова робота / магістр</option>
                                    <option value='major dyploma'>дипломна робота / магістр</option>
                                    @elseif($sw->type=='major coursework')
                                    <option value='bachaelor coursework'>курсова робота / бакалавр</option>
                                    <option value='bachaelor dyploma'>дипломна робота / бакалавр</option>
                                    <option selected="selected" value='major coursework'>курсова робота / магістр</option>
                                    <option value='major dyploma'>дипломна робота / магістр</option>
                                    @elseif($sw->type=='major dyploma')
                                    <option value='bachaelor coursework'>курсова робота / бакалавр</option>
                                    <option value='bachaelor dyploma'>дипломна робота / бакалавр</option>
                                    <option value='major coursework'>курсова робота / магістр</option>
                                    <option selected="selected" value='major dyploma'>дипломна робота / магістр</option>
                                    @else
                                    <option value='bachaelor coursework'>курсова робота / бакалавр</option>
                                    <option value='bachaelor dyploma'>дипломна робота / бакалавр</option>
                                    <option value='major coursework'>курсова робота / магістр</option>
                                    <option value='major dyploma'>дипломна робота / магістр</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="presenting_date">{{ __('Дата захисту') }}</label>
                                <input class="form-control" type="date" id="presenting_date" name="presenting_date" value="{{ $sw->presenting_date }}" min="1990-01-01" max="2040-12-31">
                            </div>
                            <div style="align-content: center !important;text-align:center !important;" class="form-group col-md-12">
                                <button type="submit" class="big-btn-in-form btn btn-primary">
                                    {{ __('Відредагувати') }}
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