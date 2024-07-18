@extends('profile.admin_profile_layout')


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

<div class="row">
    
    <div class="col-12">
        <form id="formData" action="{{ route("admin.updateProfile") }}" method="Post" enctype="multipart/form-data" novalidate="false">
            @csrf
            <input type="hidden" name="delete_photo" id="delete_photo">
            <div class="card-body">
                <p>{{ trans('profile/admin_lang.perfil_usuario_desc') }}</p>

                <div class="row form-group mb-3">
                    <div class="col-lg-6">
                     
                        <div class="form-group">
                            <label class='text-primary' for="first_name"> {{ trans('profile/admin_lang.fields.first_name') }}<span class="text-danger">*</span></label>
                            <input value="{{ $user->userProfile->first_name }}" type="text" class="form-control" name="user_profile[first_name]"  placeholder="{{ trans('profile/admin_lang.fields.first_name_helper') }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class='text-primary' for="last_name"> {{ trans('profile/admin_lang.fields.last_name') }}<span class="text-danger">*</span></label>
                            <input  value="{{ $user->userProfile->last_name }}"  type="text" class="form-control" name="user_profile[last_name]"  id="last_name" placeholder="{{ trans('profile/admin_lang.fields.last_name_helper') }}">
                        </div>
                    </div>
                </div>
                <div class="row form-group mb-3">
                    <div class="col-lg-6">
                     
                        <div class="form-group">
                            <label class='text-primary' for="first_name" class="col-12"> {{ trans('profile/admin_lang.fields.active') }}</label>
                            <input class="form-check-input toggle-switch" @if($user->active==1) checked @endif value="1" name="active" type="checkbox" id="active" disabled>
                        </div>
                    </div>
                </div>

            

                <div class="row form-group mb-3">                         
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class='text-primary' for="profile_image"> {{ trans('profile/admin_lang.fields.profile_image') }}</label>
                            <input type="file" class="form-control d-none"  accept="image/*"name="profile_image" id="profile_image" style="opacity: 0; width: 0;">
                            <div class="input-group">
                                <input type="text" class="form-control" id="nombrefichero" readonly>
                                <span class="input-group-append">
                                    <button id="btnSelectImage" class="btn btn-primary" type="button">{{ trans('profile/admin_lang.fields.search_image') }}</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="mb-3">{{ trans('profile/admin_lang.access_data') }}</h4>
                <div class=" form-group">
                    <label class='text-primary' for="email"> {{ trans('profile/admin_lang.fields.email') }}<span class="text-danger">*</span></label>
                    <input  value="{{ $user->email }}"  type="text" class="form-control" name="email" id="email" placeholder="{{ trans('profile/admin_lang.fields.email_helper') }}">
                </div>
                <div class="row form-group mb-3">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class='text-primary' for="password"> {{ trans('profile/admin_lang.fields.password') }}</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="{{ trans('profile/admin_lang.fields.password_helper') }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class='text-primary' for="password_confirm"> {{ trans('profile/admin_lang.fields.password_confirm') }}</label>
                            <input type="password" class="form-control" name="password_confirm" id="password_confirm" placeholder="{{ trans('profile/admin_lang.fields.password_confirm_helper') }}">
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">{{ trans('general/admin_lang.save') }}</button>   
            </div>
        </form>
    </div>
</div>
@endsection

@section("tab_foot")
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    
{!! JsValidator::formRequest('App\Http\Requests\AdminProfileRequest')->selector('#formData') !!}
@stop