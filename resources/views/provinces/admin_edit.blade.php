@extends('layouts.admin.default')
@section('title')
    @parent {{ $pageTitle }}
@stop
@section('head_page')
<link href="{{ asset('/assets/admin/vendor/jquery-bonsai/css/jquery.bonsai.css')}}" rel="stylesheet" />
    
@stop

@section('breadcrumb')
<li><a href="{{ url('admin/provinces') }}">{{ $title }}</a></li>
<li class="breadcrumb-item active">
        <span>
            {{ $pageTitle }} 
          </span>
    </li>
@stop

@section('content')
    
@php
    $disabled= isset($disabled)?$disabled : null;
@endphp
<section role="main" class="content-body card-margin">      
    <div class="mt-2">
         @include('layouts.admin.includes.modals')
      
        @include('layouts.admin.includes.errors')   
    </div>
    <div class="row">
        <div class="col">
            <section class="card card-featured-top card-featured-primary">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle=""></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss=""></a>
                    </div>

                    <h2 class="card-title">{{ trans("general/admin_lang.general_info") }}</h2>
                </header>
                

                <div class="card-body">  
                    <form id="formData" enctype="multipart/form-data" action="@if(empty($province->id)) {{ route("admin.provinces.store") }} @else {{ route("admin.provinces.update",$province->id) }} @endif" method="post"  novalidate="false">
                        @csrf       
                       
                        @if(empty($province->id))  
                            @method('post')
                        @else   
                            @method('patch') 
                        @endif
                          
                        <div class="card-body">
                            <div class="row form-group mb-3">
                                <div class="col-12">
                                 
                                    <div class="form-group">
                                        <label class='text-primary' for="name"> {{ trans('provinces/admin_lang.fields.name') }}<span class="text-danger">*</span></label>
                                        <input  value="{{!empty($province->name) ? $province->name :null }}" type="text" {{ $disabled }} class="form-control" name="name"  placeholder="{{ trans('provinces/admin_lang.fields.name_helper') }}">
                                    </div>
                                </div>      
                            </div>                           
                          
                            <div class="row form-group mb-3">
                                <div class="col-12 col-md-6">                     
                                    <div class="form-group">
                                        <label class='text-primary' for="active"> {{ trans('provinces/admin_lang.fields.active') }}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-switch" @if($province->active==1) checked @endif value="1"  {{ $disabled }} name="active" type="checkbox" id="active">
                                        </div>                           
                                    </div>
                                </div>                    
                                                 
                            </div>                
                        </div>
                        <div class="card-footer row">
                            <div class="col-12  d-flex justify-content-between">
            
                                <a href="{{ url('admin/provinces') }}" class="btn btn-default">{{ trans('general/admin_lang.back') }}</a>
                                @if (empty( $disabled ))
                                    <button type="submit" class="btn btn-primary">{{ trans('general/admin_lang.save') }}</button>   
                                    
                                @endif
                            </div>
                        </div>
                    </form>                     
                </div>
            </section>
        </div>
    </div>
</section>
@endsection
@section('foot_page')

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script>
    $(document).ready(function() {
      
    });

</script>

{!! JsValidator::formRequest('App\Http\Requests\AdminProvinceRequest')->selector('#formData') !!}
@stop

