@extends('layouts.front.default')
@section('title')
    @parent {{ "Login" }}
@stop
@section('head_page')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@stop
@section('content')
<section class="page-header page-header-modern bg-color-light-scale-1 page-header-lg">
    <div class="container">
        <div class="row">
            <div class="col-md-12 align-self-center p-static order-2 text-center">
                <h1 class="font-weight-bold text-dark">{{ trans('auth/login/front_lang.login') }}</h1>
            </div>
            {{-- <div class="col-md-12 align-self-center order-1">
                <ul class="breadcrumb d-block text-center">
                    <li><a href="#">{{ trans('auth/login/front_lang.home') }}</a></li>
            <li class="active">{{ trans('auth/login/front_lang.login') }}</li>
            </ul>
        </div> --}}
    </div>
    </div>
</section>

<div class="container pt-2 pb-4">

    <div class="row justify-content-center  mb-5">

        <div class="col-12 text-center">
            @php
            $setting =\App\Services\SettingsServices::getGeneral();
            @endphp
            @if(!empty($setting->image))
            <img src='{{ url('front/settings/get-image/'.$setting->image) }}' class="" alt="Porto Admin" width="150" height="150">
            @else
            <img src="{{ asset('assets/admin/img/logo.png')}}" alt="Porto Admin" width="150" height="80">
            @endif

        </div>
    </div>
    <div class="row justify-content-center mt-5 mb-5">

        <div class="col-12 col-md-12 col-lg-5 mb-5 mb-lg-0 mb-5">
            <form id="formData" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="row">
                    <div class="form-group col">
                        <label class='text-primary' for="email" class="col-md-12 col-form-label text-start">{{ trans('auth/login/front_lang.fields.email') }}</label>

                        <div class="col-md-12">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label class='text-primary' for="password" class="col-md-12 col-form-label text-start">{{ trans('auth/login/front_lang.fields.password') }}</label>

                        <div class="col-md-12">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="form-group col-md-auto">
                        <div class="custom-control custom-checkbox">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class='text-primary' class="form-check-label" for="remember">
                                {{ trans('auth/login/front_lang.fields.remember_me') }}
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-md-auto">
                        <a class="text-decoration-none text-color-dark text-color-hover-primary font-weight-semibold text-2" href="{{ route('password.request') }}">
                            {{ trans('auth/login/front_lang.forgot_password') }}</a>
                    </div>

                </div>
                <div class="row mt-3 mb-4">
                    <div class="col-12">
                        <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                        <small id="recaptchapError" class="text-danger" for=""></small>
                        @error('captcha')
                            <small id="" class="text-danger" for="">{{ $message }}</small>                          
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <button type="submit" class="btn btn-secondary btn-modern w-100 text-uppercase rounded-0 font-weight-bold text-3 py-3" data-loading-text="Loading..."> {{ trans('auth/login/front_lang.login') }}</button>
                    </div>
                </div>



            </form>
        </div>

    </div>

</div>

@stop
@section("foot_page")
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

<script>
  document.getElementById('formData').addEventListener('submit', function(event) {
        $("#recaptchapError").html("");
        var recaptcha = document.getElementById('g-recaptcha-response');
        if (recaptcha.value === '') {
            event.preventDefault(); // Evita el envío del formulario si no se resolvió el reCAPTCHA
            $("#recaptchapError").html("Por favor, completa el reCAPTCHA.");
            // toastr.error("'Por favor, completa el reCAPTCHA.'")
        }else{
            $('formData').submit();
        }
    });
</script>
{!! JsValidator::formRequest('App\Http\Requests\FrontLoginRequest')->selector('#formData') !!}
@stop
