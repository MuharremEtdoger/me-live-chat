@extends('layouts.header')

@section('content')
<div class="container register-top-container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <p class="me-top-desc"><strong>Hoşgeldiniz!</strong>Sisteme üyeliğiniz varsa giriş yapabilirsiniz. Üyeliğiniz yoksa kayıt olabilirsiniz.</p>
            <nav class="nav nav-pills flex-column flex-sm-row tabs-login-and-register">
                <a class="flex-sm-fill text-sm-center nav-link"  href="{{ route('login') }}">{{ __('Giriş Yap') }}</a>
                <a class="flex-sm-fill text-sm-center nav-link active" aria-current="page" href="{{ route('register') }}">{{ __('Kayıt Ol') }}</a>
            </nav>              
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-12">    
                                <div class="form-group"> 
                                    <label for="name" class="col-md-4 col-form-label text-md-start">{{ __('Adınız') }}</label> 
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror                                
                                </div>
                            </div>                              
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">    
                                <div class="form-group"> 
                                    <label for="email" class="col-md-4 col-form-label text-md-start">{{ __('E-Mail Adresiniz') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>                              
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">    
                                <div class="form-group"> 
                                    <label for="password" class="col-md-4 col-form-label text-md-start">{{ __('Şifre') }}</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>                              
                        </div>                                                
                        <div class="row mb-3">
                            <div class="col-md-12">    
                                <div class="form-group"> 
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-start">{{ __('Şifre Tekrar') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>                              
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary reg-log-btn">
                                    {{ __('Kayıt Ol') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
