@extends('layouts.front.default')
@section('title')
    @parent {{ "Registrar" }}
@stop
@section('head_page')
    
@stop
@section('content')
<section class="page-header page-header-modern bg-color-light-scale-1 page-header-lg">
    <div class="container">
        <div class="row">
            <div class="col-md-12 align-self-center p-static order-2 text-center">
                <h1 class="font-weight-bold text-dark">{{ trans('auth/register/front_lang.register') }}</h1>
            </div>
            <div class="col-md-12 align-self-center order-1">
                <ul class="breadcrumb d-block text-center">
                    <li><a href="#">{{ trans('auth/login/front_lang.home') }}</a></li>
                    <li class="active">{{ trans('auth/register/front_lang.register') }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<div class="container py-4">

    <div class="row justify-content-center mt-5 mb-5">
        <div class="col-12 col-md-12 col-lg-5 mb-5 mb-lg-0 mb-5">
            <form method="POST" id="formData" action="{{ route('register') }}">
                @csrf
                <div class="row">
                    <div class="form-group col">
                        <label class='text-primary' for="first_name" class="col-md-12 col-form-label text-start">{{ trans('auth/register/front_lang.fields.first_name') }}</label>

                        <div class="col-md-12">
                            <input id="first_name" placeholder="{{ trans('auth/register/front_lang.fields.first_name_helper') }}" type="text" class="form-control @error('first_name') is-invalid @enderror" name="user_profile[first_name]" autofocus>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label class='text-primary' for="last_name" class="col-md-12 col-form-label text-start">{{ trans('auth/register/front_lang.fields.last_name') }}</label>

                        <div class="col-md-12">
                            <input id="last_name" placeholder="{{ trans('auth/register/front_lang.fields.last_name_helper') }}" type="text" class="form-control @error('last_name') is-invalid @enderror" name="user_profile[last_name]" >

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label class='text-primary' for="email" class="col-md-12 col-form-label text-start">{{ trans('auth/register/front_lang.fields.email') }}</label>

                        <div class="col-md-12">
                            <input id="email" placeholder="{{ trans('auth/register/front_lang.fields.email_helper') }}" type="text" class="form-control @error('email') is-invalid @enderror" name="email" >

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label class='text-primary' for="password" class="col-md-12 col-form-label text-start">{{ trans('auth/register/front_lang.fields.password') }}</label>

                        <div class="col-md-12">
                            <input id="password" placeholder="{{ trans('auth/register/front_lang.fields.password_helper') }}" type="password" class="form-control @error('password') is-invalid @enderror" name="password" >

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label class='text-primary' for="password-confirm" class="col-md-12 col-form-label text-start">{{ trans('auth/register/front_lang.fields.password_confirm') }}</label>

                        <div class="col-md-12">
                            <input id="password-confirm" placeholder="{{ trans('auth/register/front_lang.fields.password_confirm_helper') }}" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col">
                        <button type="submit" class="btn btn-secondary btn-modern w-100 text-uppercase rounded-0 font-weight-bold text-3 py-3" data-loading-text="Loading...">   {{ trans('auth/register/front_lang.registered') }}</button>
                        </div>
                </div>
            </form>
        </div>
        
    </div>

</div>
@stop

@section("foot_page")

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\FrontRegisterRequest')->selector('#formData') !!}
@stop


