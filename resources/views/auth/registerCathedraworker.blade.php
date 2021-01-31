@extends('layouts.app')
@section('content')
<div id='register-as-teacher-form-cont' class="container">
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
                        <h2 class="title text-center">Зареєструвати робітника кафедри</h2>
                        <div class="status alert alert-success" style="display: none"></div>
                        <form method="POST" action="{{ route('add-cathedraworker') }}">
                            @csrf
                            <div class="form-group col-md-12">
                                <label for="name">{{ __("Ім'я") }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="surname">{{ __('Прізвище') }}</label>
                                <input id="name" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" required autocomplete="surname" autofocus>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="fathername">{{ __('По-батькові') }}</label>
                                <input id="name" type="text" class="form-control @error('fathername') is-invalid @enderror" name="fathername" value="{{ old('fathername') }}" required autocomplete="fathername" autofocus>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="gender">{{ __('Стать') }}</label>
                                <select class="form-control" name="gender" id="gender">
                                    <option value="male">чоловіча</option>
                                    <option value="female">жіноча</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="email">{{ __('Email-адреса') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            </div>
                            <div class="form-group col-md-12">
                            <label for="cathedra">{{ __('Кафедра') }}</label>
                                <select class="form-control" name="cathedra" id="cathedra">
                                    @foreach($cathedras as $value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="password">{{ __('Пароль') }}</label>
                                 <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            </div>
                            <div class="form-group col-md-12">
                            <label for="password-confirm">{{ __('Перевірка паролю') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <div style="align-content: center !important;text-align:center !important;" class="form-group col-md-12">
                                <button type="submit" class="big-btn-in-form btn btn-primary">
                                    {{ __('Зареєструвати') }}
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