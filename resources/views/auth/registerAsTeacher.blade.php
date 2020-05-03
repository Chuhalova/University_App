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
                        <h2 class="title text-center">Зареєструватись як викладач</h2>
                        <div class="status alert alert-success" style="display: none"></div>
                        <form method="POST" action="{{ route('add-teacher') }}">
                            @csrf
                            <div class="form-group col-md-12">
                                <label for="workbooknumber">{{ __('Номер трудової книжки') }}</label>
                                <input class="form-control" id="workbooknumber" type="text" class="form-control" name="workbooknumber" required autocomplete="work book number" autofocus>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="email">{{ __('E-Mail адреса') }}</label>
                                <input class="form-control" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label for="password">{{ __('Пароль') }}</label>
                                <input class="form-control" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label for="password-confirm">{{ __('Підтвердити пароль') }}</label>
                                <input class="form-control" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <div style="align-content: center !important;text-align:center !important;" class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Зареєструватись') }}
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