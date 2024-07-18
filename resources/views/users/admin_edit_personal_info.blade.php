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

@section('tab_content_4')
@php
$disabled= isset($disabled)?$disabled : null;
@endphp
<div class="row">
    
    <div class="col-12">
        <form id="formData" action="{{ route("admin.users.updatePersonalInfo",$user->id) }}" method="Post" enctype="multipart/form-data" novalidate="false">
            @csrf
            <input type="hidden" name="delete_photo" id="delete_photo">
            <div class="card-body">

                <div class="row form-group mb-3">
                    <div class="col-lg-6">
                     
                        <div class="form-group">
                            <label for="birthday"> {{ trans('users/admin_lang.fields.birthday') }}</label>
                            <input value="{{ $user->userProfile->birthdayFormatted }}" type="text" {{ $disabled }} class="form-control" id="birthday" name="user_profile[birthday]"  placeholder="{{ trans('users/admin_lang.fields.birthday_helper') }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="identification"> {{ trans('users/admin_lang.fields.identification') }}</label>
                            <input  value="{{ $user->userProfile->identification }}" maxlength="15" type="text" {{ $disabled }} class="form-control" name="user_profile[identification]"  id="identification" placeholder="{{ trans('users/admin_lang.fields.identification_helper') }}">
                        </div>
                    </div>
                </div>
                <div class="row form-group mb-3">
                    <div class="col-lg-6">
                     
                        <div class="form-group">
                            <label for="phone"> {{ trans('users/admin_lang.fields.phone') }}</label>
                            <input value="{{ $user->userProfile->phone }}" type="text"  maxlength="15" {{ $disabled }} class="form-control" name="user_profile[phone]"  placeholder="{{ trans('users/admin_lang.fields.phone_helper') }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="mobile"> {{ trans('users/admin_lang.fields.mobile') }}</label>
                            <input  value="{{ $user->userProfile->mobile }}"  type="text"  maxlength="15" {{ $disabled }} class="form-control" name="user_profile[mobile]"  id="mobile" placeholder="{{ trans('users/admin_lang.fields.mobile_helper') }}">
                        </div>
                    </div>
                </div>

                <div class="row form-group mb-3">
                    <div class="col-lg-6">
                     
                        <div class="form-group">
                            <label for="gender" class="col-12"> {{ trans('users/admin_lang.fields.gender') }}</label>
                            <select {{ $disabled }} class="form-control select2" name="user_profile[gender]" id="gender"> 
                                @foreach ($genders as $key=>$value)
                                    <option value="{{ $key }}" @if($user->userProfile->gender ==$key) selected @endif>{{ $value }}</option>
                                @endforeach 
                            </select>    
                        </div>
                    </div>
                </div>
                <div class="row form-group mb-3">
                    <div class="col-12 col-md-6">                     
                        <div class="form-group">
                            <label for="province_id" class="col-12"> {{ trans('users/admin_lang.fields.province_id') }}</label>
                            <select {{ $disabled }} class="form-control select2" name="user_profile[province_id]" id="province_id">
                                <option value="">{{ trans('users/admin_lang.fields.province_id_helper') }}</option>   
                                @foreach ($provincesList as $province)
                                    <option value="{{ $province->id }}" @if($user->userProfile->province_id ==$province->id) selected @endif>{{ $province->name }}</option>
                                @endforeach 
                            </select>    
                        
                        </div>
                    </div>    
                    <div class="col-12 col-md-6">                     
                        <div class="form-group">
                            <label for="municipio_id" class="col-12"> {{ trans('users/admin_lang.fields.municipio_id') }}  </label>
                            <select {{ $disabled }} class="form-control select2" name="user_profile[municipio_id]" id="municipio_id">
                                <option value="">{{ trans('users/admin_lang.fields.municipio_id_helper') }}</option>   
                                @foreach ($municipiosList as $municipio)
                                    <option value="{{ $municipio->id }}" @if($user->userProfile->municipio_id ==$municipio->id) selected @endif>{{ $municipio->name }}</option>
                                @endforeach 
                            </select>    
                        </div>
                    </div>                        
                </div>
                <div class="row form-group mb-3">
                    <div class="col-lg-12">
                     
                        <div class="form-group">
                            <label for="address"> {{ trans('users/admin_lang.fields.address') }}</label>
                            <input value="{{ $user->userProfile->address }}" type="text" {{ $disabled }} class="form-control" name="user_profile[address]"  placeholder="{{ trans('users/admin_lang.fields.address_helper') }}">
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="card-footer row">
                <div class="col-12  d-flex justify-content-between">

                    <a href="{{ url('admin/users') }}" class="btn btn-default">{{ trans('general/admin_lang.back') }}</a>
                    @if (empty($disabled))
                     <button type="submit" class="btn btn-success">{{ trans('general/admin_lang.save') }}</button>  
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
    $(document).ready(function() {
        $('.select2').select2();
       $('#birthday').datepicker(
        {
            language: 'es',
            format: 'dd/mm/yyyy',
            orientation:'bottom',
            autoclose: true
        }
       );
    });
    $("#province_id").change(function(){
        $('#municipio_id').html("<option value='' >{{ trans('centers/admin_lang.fields.municipio_id_helper') }}</option>");
        $.ajax({
            url     : "{{ url('admin/municipios/municipios-list') }}/"+$(this).val(),
            type    : 'GET',
            "headers": {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
            data: {_method: 'delete'},
            success : function(data) {
                console.log(data)
                $.each(data, function(index, value) {
                    $('#municipio_id').append("<option value='"+value['id']+"' >"+value['name']+"</option>");
                   
                });
            }

        });
    });
</script>
{{-- {!! JsValidator::formRequest('App\Http\Requests\AdminProfilePersonalInfoRequest')->selector('#formData') !!} --}}
@stop