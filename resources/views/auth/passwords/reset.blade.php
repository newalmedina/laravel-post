@extends('layouts.front.default')
@section('title')
    @parent {{ "Restablecer contraseña" }}
@stop
@section('head_page')

@stop
@section('content')
<section class="page-header page-header-modern bg-color-light-scale-1 page-header-lg">
    <div class="container">
        <div class="row">
            <div class="col-md-12 align-self-center p-static order-2 text-center">
                <h1 class="font-weight-bold text-dark">Restablecer contraseña</h1>
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
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <div class="row">
                    <div class="form-group col">
                        <label class='text-primary' for="email" class="col-md-12 col-form-label text-start">Correo</label>

                        <div class="col-md-12">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

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
                        <label class='text-primary' for="email" class="col-md-12 col-form-label text-start">Contraseña</label>

                        <div class="col-md-12">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label class='text-primary' for="email" class="col-md-12 col-form-label text-start">Confirmar contraseña</label>

                        <div class="col-md-12">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                           
                        </div>
                    </div>
                    
                </div>
                
            
                <div class="row">
                    <div class="form-group col">
                        <button type="submit" class="btn btn-secondary btn-modern w-100 text-uppercase rounded-0 font-weight-bold text-3 py-3" data-loading-text="Loading...">     Restablecer Contraseña </button>
                    </div>
                </div>



            </form>
        </div>

    </div>

</div>

@stop
@section("foot_page")
@stop
