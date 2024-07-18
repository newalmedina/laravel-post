@extends('roles.admin_role_layout')


@section('tab_head')
   
@stop

@section('tab_breadcrumb')
    <li class="breadcrumb-item active"><a href="#">{{ $pageTitle }}</a></li>
@stop

@section('tab_content_1')

<div class="row">
    <div class="col-12">
        <form id="formData" action="{{!empty($role->id)?route("admin.roles.update",$role->id) :route("admin.roles.store") }}" method="post"  novalidate="false">
            @csrf     
            @if (!empty($role->id))
             @method('patch')    
             
             @else
             @method('post')    
                
            @endif  
            <div class="card-body">
                <div class="row form-group mb-3">
                    <div class="col-lg-12">
                     
                        <div class="form-group">
                            <label class='text-primary' for="display_name"> {{ trans('roles/admin_lang.fields.display_name') }}<span class="text-danger">*</span></label>
                            <input value="{{ $role->display_name }}" type="text" class="form-control" name="display_name"  placeholder="{{ trans('roles/admin_lang.fields.display_name_helper') }}">
                        </div>
                    </div>                    
                </div>
                <div class="row form-group">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class='text-primary' for="last_name"> {{ trans('roles/admin_lang.fields.description') }}</label>
                            <textarea class="form-control" name="description" id="description"  cols="30" rows="10">{{ $role->description }}</textarea>
                         </div>
                    </div>               
                </div>
                <div class="row form-group mb-3">
                    <div class="col-12 col-md-6">                     
                        <div class="form-group">
                            <label class='text-primary' for="active"> {{ trans('roles/admin_lang.fields.active') }}</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input toggle-switch" @if($role->active==1) checked @endif value="1" name="active" type="checkbox" id="active">
                            </div>                           
                        </div>
                    </div>                    
                                       
                </div> 

                
            </div>
            <div class="card-footer row ">
                <div class="col-12 mt-2 d-flex justify-content-between">
                    <a href="{{ url('admin/roles') }}" class="btn btn-default">{{ trans('general/admin_lang.back') }}</a>
                    
                    <button type="submit" class="btn btn-primary">{{ trans('general/admin_lang.save') }}</button>   
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section("tab_foot")
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

{!! JsValidator::formRequest('App\Http\Requests\AdminRoleRequest')->selector('#formData') !!}
@stop