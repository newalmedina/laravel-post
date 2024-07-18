@extends('layouts.front.simple')
@section('head_page')
    
@stop
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5" style="margin-top: 250px">
            <div class="card">
                <div class="card-header bg-secondary  bg-secondary text-white text-center" style="font-size:25px;">{{ trans('auth/change_password/front_lang.change_password') }}</div>

                <div class="card-body text-left">
                 

                     <p class="text-warning">  {{ trans('auth/change_password/front_lang.change_password_text_1') }}</p>
                    <form class="d-inline" id="formData" method="POST" action="{{ route('front.change_password_update') }}">
                        @csrf
                        @method('post') 
                         <div class="row form-group mb-3">
                                <div class="col-12">
                                 
                                    <div class="form-group">
                                        <label class='text-primary' for="password_old"> {{ trans('auth/change_password/front_lang.password_old') }}<span class="text-danger">*</span></label>
                                        <input  type="password"  class="form-control" name="password_old"  placeholder="{{ trans('auth/change_password/front_lang.password_old_helper') }}">
                                        @error('password_old')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>    
                                 <div class="col-12">
                                 
                                    <div class="form-group">
                                        <label class='text-primary' for="password"> {{ trans('auth/change_password/front_lang.password') }}<span class="text-danger">*</span></label>
                                        <input  type="password"  class="form-control" value="" name="password"  placeholder="{{ trans('auth/change_password/front_lang.password_helper') }}">
                                    </div>
                                </div>    
                                 <div class="col-12">
                                 
                                    <div class="form-group">
                                        <label class='text-primary' for="password_confirm"> {{ trans('auth/change_password/front_lang.password_confirm') }}<span class="text-danger">*</span></label>
                                        <input  type="password"  class="form-control" value="" name="password_confirm"  placeholder="{{ trans('auth/change_password/front_lang.password_confirm_helper') }}">
                                    </div>
                                </div>    
                                 <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-secondary">{{ trans('auth/change_password/front_lang.change_password_btn') }}</button>.
                                </div>        
                             </div>    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('foot_page')

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script>
  

</script>

{!! JsValidator::formRequest('App\Http\Requests\FrontChangePasswordRequest')->selector('#formData') !!}
@stop