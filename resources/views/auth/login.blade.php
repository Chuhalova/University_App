@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="shopper-info">
				<p>{{ __('Увійти') }}</p>
                @if($errors->any())
                     <ul class="alert alert-danger">
                     @foreach ($errors->all() as $error)
                        <li >{{ $error }}</li>
                    @endforeach
                    </ul>
                @endif 
                <form method="POST" action="{{ route('login') }}">
                @csrf
                <label for="email">{{ __('E-Mail адреса') }}</label>
                    <input placeholder="E-Mail адреса" id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <label for="password">{{ __('Пароль') }}</label>
                    <input placeholder="Пароль" id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

