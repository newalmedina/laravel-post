@extends('users.admin_users_layout')


@section('tab_head')
   
@stop

@section('tab_breadcrumb')
    <li class="breadcrumb-item active">
        <span>
            {{ $pageTitle }} 
          </span>
    </li>
@stop

@section('tab_content_1')
@php
$disabled= isset($disabled)?$disabled : null;
@endphp
<div class="row">
    

    <div class="col-12">
        <form id="formData" action="@if(empty($user->id)) {{ route("admin.users.store") }} @else {{ route("admin.users.update",$user->id) }} @endif" method="post"  novalidate="false">
            @csrf       
           
            @if(empty($user->id))  
                @method('post')
            @else   
                @method('patch') 
            @endif
              
            <div class="card-body">
              
                <div class="row form-group mb-3">
                    <div class="col-12 col-md-6">
                     
                        <div class="form-group">
                            <label class='text-primary' for="first_name"> {{ trans('users/admin_lang.fields.first_name') }}dsadsa<span class="text-danger">*</span></label>
                            <input value="{{!empty($user->userProfile->first_name) ? $user->userProfile->first_name :null }}" type="text"  {{ $disabled }} class="form-control" name="user_profile[first_name]"  placeholder="{{ trans('users/admin_lang.fields.first_name_helper') }}">
                        </div>
                    </div>    
                    
                    <div class="col-12 col-md-6">
                     
                        <div class="form-group">
                            <label class='text-primary' for="last_name"> {{ trans('users/admin_lang.fields.last_name') }}<span class="text-danger">*</span></label>
                            <input value="{{!empty($user->userProfile->last_name) ? $user->userProfile->last_name :null }}" type="text"  {{ $disabled }} class="form-control" name="user_profile[last_name]"  placeholder="{{ trans('users/admin_lang.fields.last_name_helper') }}">
                        </div>
                    </div>     
                </div>

                <div class="row form-group mb-3">
                    <div class="col-12">
                     
                        <div class="form-group">
                            <label class='text-primary' for="email"> {{ trans('users/admin_lang.fields.email') }}<span class="text-danger">*</span></label>
                            <input value="{{ $user->email }}" type="text"  {{ $disabled }} class="form-control" name="email"  placeholder="{{ trans('users/admin_lang.fields.email_helper') }}">
                        </div>
                    </div>                    
                </div>
                <div class="row form-group mb-3">
                    <div class="col-12 col-md-6">
                     
                        <div class="form-group">
                            <label class='text-primary' for="password"> {{ trans('users/admin_lang.fields.password') }}<span class="text-danger">*</span></label>
                            <input value="" type="text"  {{ $disabled }} class="form-control" id="password" name="password"  placeholder="{{ trans('users/admin_lang.fields.password_helper') }}">
                        </div>
                    </div>  
                    <div class="col-12 col-md-6">
                     
                        <div class="form-group">
                            <label class='text-primary' for="password_confirm"> {{ trans('users/admin_lang.fields.password_confirm') }}<span class="text-danger">*</span></label>
                            <input value="" type="text"  {{ $disabled }} class="form-control" id="password_confirm" name="password_confirm"  placeholder="{{ trans('users/admin_lang.fields.password_confirm_helper') }}">
                        </div>
                    </div>                    
                </div>
                @if (empty($disabled))
                    <div class="row form-group mb-3">
                        <div class="col-12 col-md-6">
                            <button onclick="generatePassword(8)" type="button" class="btn btn-info">{{ trans('users/admin_lang.generate_password') }}</button>                        
                        </div>                    
                    </div>
                                      
                @endif           
               

                <div class="row form-group mb-3">
                    <div class="col-12">
                     
                        <div class="form-group">
                            <label class='text-primary' for="active"> {{ trans('users/admin_lang.fields.active') }}</label>
                            <div class="form-check form-switch">
                                <input  {{ $disabled }} class="form-check-input toggle-switch" @if($user->active==1) checked @endif value="1" name="active" type="checkbox" id="active">
                            </div>                           
                        </div>
                    </div>                    
                </div>
                <div class="row form-group mb-3">
                    <div class="col-12">
                     
                        <div class="form-group">
                            <label class='text-primary' for="active"> {{ trans('users/admin_lang.fields.email_verified_at') }}</label>
                            @if(!empty($user->email_verified_at))                                     
                                <small class="text-muted" style="font-size:8px">
                                       ({{\Carbon\Carbon::parse($user->email_verified_at)->format("d/m/Y H:i")}})
                                </small>                                    
                            @endif
                            <div class="form-check form-switch">
                                <input  {{ $disabled }} class="form-check-input toggle-switch" @if(!empty($user->email_verified_at)) checked @endif value="1" name="email_verified_at" type="checkbox" id="email_verified_at">                                
                            </div>                           
                        </div>
                    </div>                    
                </div>
                <div class="row form-group mb-3">
                    <div class="col-12">
                     
                        <div class="form-group">
                            <label class='text-primary' for="active"> {{ trans('users/admin_lang.fields.password_changed_at') }}</label>
                             @if(!empty($user->password_changed_at))                                     
                                <small class="text-muted" style="font-size:8px">
                                       ({{\Carbon\Carbon::parse($user->password_changed_at)->format("d/m/Y H:i")}})
                                </small>                                    
                            @endif
                            <div class="form-check form-switch">
                                <input  {{ $disabled }} class="form-check-input toggle-switch" @if(!empty($user->password_changed_at)) checked @endif value="1" name="password_changed_at" type="checkbox" id="password_changed_at">
                            </div>                           
                        </div>
                    </div>                    
                </div>
                <div class="row form-group mb-3">
                    <div class="col-12">
                     
                        <div class="form-group">
                            <label class='text-primary' for="active"> {{ trans('users/admin_lang.fields.permit_recieve_emails') }}</label>
                            <div class="form-check form-switch">
                                <input  {{ $disabled }} class="form-check-input toggle-switch" @if($user->permit_recieve_emails==1) checked @endif value="1" name="permit_recieve_emails" type="checkbox" id="permit_recieve_emails">
                            </div>                           
                        </div>
                    </div>                    
                </div>
                

                
            </div>
            <div class="card-footer row">
                <div class="col-12  d-flex justify-content-between">

                    <a href="{{ url('admin/users') }}" class="btn btn-default">{{ trans('general/admin_lang.back') }}</a>
                    @if (empty($disabled))
                     <button type="submit" class="btn btn-primary">{{ trans('general/admin_lang.save') }}</button>  
                     @endif    
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section("tab_foot")

<script src="{{ asset('assets/admin/vendor/ios7-switch/ios7-switch.js')}}"></script>
    
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script>
    
    function generatePassword(lenght) {
       var caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+";
            var caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+";
            var contrasena = "";

            // Generar al menos una letra mayúscula
            contrasena += String.fromCharCode(Math.floor(Math.random() * 26) + 65);

            // Generar al menos un caracter especial
            contrasena += caracteres.charAt(Math.floor(Math.random() * 14) + 52);

            // Generar 6 caracteres aleatorios
            for (var i = 2; i < 7; i++) {
                contrasena += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
            }
             contrasena += "*";
        $("#password").val(contrasena);
        $("#password_confirm").val(contrasena);
      //  return pass;
    }
</script>
{!! JsValidator::formRequest('App\Http\Requests\AdminUserRequest')->selector('#formData') !!}
@stop