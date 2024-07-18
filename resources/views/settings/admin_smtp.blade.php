@extends('settings.admin_settings_layout')


@section('tab_head')
   
@stop

@section('tab_breadcrumb')
    <li class="breadcrumb-item active">
        <span>
            {{ $pageTitle }} 
          </span>
    </li>
@stop

@section('tab_content_2')
@php
$disabled= isset($disabled)?$disabled : null;
@endphp
<div class="row">
   
    <div class="col-12">
        <form id="formData" enctype="multipart/form-data" action="{{ route('admin.settings.smtp-update') }}" method="post"  novalidate="false">
            @csrf 
             @method('patch')
          
              
            <div class="card-body">
                <div class="row form-group mb-3">
                    <div class="col-12">
                     
                        <div class="form-group">
                            <label class='text-primary' for="MAIL_MAILER"> {!! trans('settings/admin_smtp_lang.fields.MAIL_MAILER') !!}<span class="text-danger">*</span></label>
                            <input value="{{!empty($settingSmtp->MAIL_MAILER) ? $settingSmtp->MAIL_MAILER :null }}" type="text"  @if ($disabledForm) disabled  @endif      class="form-control"    name="MAIL_MAILER"  placeholder="{{ trans('settings/admin_smtp_lang.fields.MAIL_MAILER_helper') }}">
                        </div>
                    </div>      
                </div>
             
                <div class="row form-group mb-3">
                    <div class="col-12 col-md-6">
                     
                        <div class="form-group">
                            <label class='text-primary' for="MAIL_HOST"> {!! trans('settings/admin_smtp_lang.fields.MAIL_HOST') !!}<span class="text-danger">*</span></label>
                            <input value="{{!empty($settingSmtp->MAIL_HOST) ? $settingSmtp->MAIL_HOST :null }}" type="text"  @if ($disabledForm) disabled  @endif      class="form-control"    name="MAIL_HOST"  placeholder="{{ trans('settings/admin_smtp_lang.fields.MAIL_HOST_helper') }}">
                        </div>
                    </div>      
                    <div class="col-12 col-md-3">
                     
                        <div class="form-group">
                            <label class='text-primary' for="MAIL_ENCRYPTION"> {!! trans('settings/admin_smtp_lang.fields.MAIL_ENCRYPTION') !!}<span class="text-danger">*</span></label>
                            <input value="{{!empty($settingSmtp->MAIL_ENCRYPTION) ? $settingSmtp->MAIL_ENCRYPTION :null }}" type="text"  @if ($disabledForm) disabled  @endif      class="form-control"    name="MAIL_ENCRYPTION"  placeholder="{{ trans('settings/admin_smtp_lang.fields.MAIL_ENCRYPTION_helper') }}">
                        </div>
                    </div>      
                    <div class="col-12 col-md-3">
                     
                        <div class="form-group">
                            <label class='text-primary' for="MAIL_PORT"> {!! trans('settings/admin_smtp_lang.fields.MAIL_PORT') !!}<span class="text-danger">*</span></label>
                            <input value="{{!empty($settingSmtp->MAIL_PORT) ? $settingSmtp->MAIL_PORT :null }}" type="text"  @if ($disabledForm) disabled  @endif      class="form-control"    name="MAIL_PORT"  placeholder="{{ trans('settings/admin_smtp_lang.fields.MAIL_PORT_helper') }}">
                        </div>
                    </div>      
                </div>
                <div class="row form-group mb-3">
                    <div class="col-12 col-md-6">
                     
                        <div class="form-group">
                            <label class='text-primary' for="MAIL_USERNAME"> {{ trans('settings/admin_smtp_lang.fields.MAIL_USERNAME') }}<span class="text-danger">*</span></label>
                            <input value="{{!empty($settingSmtp->MAIL_USERNAME) ? $settingSmtp->MAIL_USERNAME :null }}" type="text"  @if ($disabledForm) disabled  @endif      class="form-control"    name="MAIL_USERNAME"  placeholder="{{ trans('settings/admin_smtp_lang.fields.MAIL_USERNAME_helper') }}">
                        </div>
                    </div>      
                    <div class="col-12 col-md-6">
                     
                        <div class="form-group">
                            <label class='text-primary' for="MAIL_PASSWORD"> {{ trans('settings/admin_smtp_lang.fields.MAIL_PASSWORD') }}<span class="text-danger">*</span></label>
                            <input value="{{!empty($settingSmtp->MAIL_PASSWORD) ? $settingSmtp->MAIL_PASSWORD :null }}" type="password"  @if ($disabledForm) disabled  @endif      class="form-control"    name="MAIL_PASSWORD"  placeholder="{{ trans('settings/admin_smtp_lang.fields.MAIL_PASSWORD_helper') }}">
                        </div>
                    </div>      
                </div>
                <div class="row form-group mb-3">
                    <div class="col-12 col-md-6">
                     
                        <div class="form-group">
                            <label class='text-primary' for="MAIL_FROM_ADDRESS"> {!! trans('settings/admin_smtp_lang.fields.MAIL_FROM_ADDRESS') !!}<span class="text-danger">*</span></label>
                            <input value="{{!empty($settingSmtp->MAIL_FROM_ADDRESS) ? $settingSmtp->MAIL_FROM_ADDRESS :null }}" type="email"  @if ($disabledForm) disabled  @endif      class="form-control"    name="MAIL_FROM_ADDRESS"  placeholder="{{ trans('settings/admin_smtp_lang.fields.MAIL_FROM_ADDRESS_helper') }}">
                        </div>
                    </div>      
                    <div class="col-12 col-md-6">
                     
                        <div class="form-group">
                            <label class='text-primary' for="MAIL_FROM_NAME"> {!! trans('settings/admin_smtp_lang.fields.MAIL_FROM_NAME') !!}<span class="text-danger">*</span></label>
                            <input value="{{!empty($settingSmtp->MAIL_FROM_NAME) ? $settingSmtp->MAIL_FROM_NAME :null }}" type="text"  @if ($disabledForm) disabled  @endif      class="form-control"    name="MAIL_FROM_NAME"  placeholder="{{ trans('settings/admin_smtp_lang.fields.MAIL_FROM_NAME_helper') }}">
                        </div>
                    </div>      
                </div>
                <div class="row form-group mb-3">
                    <div class="col-12">
                     
                        <div class="form-group">
                            <label class='text-primary' for="active"> {!! trans('settings/admin_smtp_lang.fields.MAIL_SEND_ACTIVE') !!}</label>
                            <div class="form-check form-switch">
                                <input  {{ $disabledForm }} class="form-check-input toggle-switch" @if($settingSmtp->MAIL_SEND_ACTIVE==1) checked @endif value="1" name="MAIL_SEND_ACTIVE" type="checkbox" id="MAIL_SEND_ACTIVE">
                            </div>                           
                        </div>
                    </div>                    
                </div>
             
               
                           
            </div>
            <div class=" row">
                <div class="col-12  d-flex justify-content-between">

                    <a href="{{ url('admin/settings') }}" class="btn btn-default">{{ trans('general/admin_lang.back') }}</a>
                    @if ( !  $disabledForm )
                    <button type="submit" class="btn btn-primary">{{ trans('general/admin_lang.save') }}</button>   
                        
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section("tab_foot")
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

<script>
</script>
     

{!! JsValidator::formRequest('App\Http\Requests\AdminSettingSmtpRequest')->selector('#formData') !!}
@stop