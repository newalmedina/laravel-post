@extends('layouts.front.simple')
@section('title')
    @parent {{ "Verificar correo" }}
@stop
@section('head_page')
    
@stop
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5" style="margin-top: 250px">
            <div class="card">
                <div class="card-header bg-secondary  bg-secondary text-white text-center" style="font-size:25px;">{{ trans('auth/verify/front_lang.verify_email') }}</div>

                <div class="card-body text-center">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ trans('auth/verify/front_lang.verify_email_send_success') }}
                        </div>
                    @endif

                  <p>  {{ trans('auth/verify/front_lang.verify_email_text_1') }}</p>
                  <p>  {{ trans('auth/verify/front_lang.verify_email_text_2') }}</p>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-secondary mt-5">{{ trans('auth/verify/front_lang.verify_email_btn') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section("foot_page")
<script>
    @if(!empty(Auth::user()->email_verified_at))
        window.location.href = "{{url('/')}}"
    @endif
</script>
@stop