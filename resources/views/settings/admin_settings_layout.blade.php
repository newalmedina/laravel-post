@extends('layouts.admin.default')
@section('title')
    @parent {{ $pageTitle }}
@stop
@section('head_page')
<link href="{{ asset('/assets/admin/vendor/jquery-bonsai/css/jquery.bonsai.css')}}" rel="stylesheet" />
    
@stop

@section('breadcrumb')
@yield('tab_breadcrumb')
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


    <div class="row mt-2">
            <div class="col-12 col-md-3">
                <section class="card">
                
                    <div class="card-body">
                        
                        <div class="thumb-info mb-3">
                            <div id="fileOutput">
                                @if(!empty($setting->image))
                                    <img src='{{ url('admin/settings/get-image/'.$setting->image) }}' id='image_ouptup' class="rounded img-fluid" >
                                @else
                                    <img src="{{ asset("/assets/front/img/!logged-user.jpg") }}" class="rounded img-fluid" >
                                @endif
                            </div>
                            @if(!empty($setting->image) && empty($disabled) && isset($generalSetting))                           
                                <div id="remove"  onclick="deleteElement()" class="text-danger mt-2" style="@if($setting->image=='') display: none; @endif cursor: pointer; text-align: center;"><i class="fa fa-times" aria-hidden="true"></i> {{ trans('settings/admin_lang.quit_image') }} </div>
                            @endif
                        </div>
                    </div>
                </section>
            </div>
        <div class="col-12    col-md-9 ">
            <div class="tabs tabs-primary">
                <ul class="nav nav-tabs" id="custom-tabs">
                    @if (auth()->user()->isAbleTo('admin-settings-show') || auth()->user()->isAbleTo('admin-settings-update')) 
                        <li class="nav-item @if ($tab == 'tab_1') active @endif">
                            <a id="tab_1" class="nav-link" data-bs-target="#tab_1-1" data-bs-toggle="tabajax"
                                href="{{ route("admin.settings") }}"
                                data-target="#tab_1-1" aria-controls="tab_1-1" aria-selected="true">
                                {{ trans('settings/admin_lang.general_info') }}
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->isAbleTo('admin-settings-smtp-update') || auth()->user()->isAbleTo('admin-settings-smtp-show')) 
                        <li class="nav-item @if ($tab == 'tab_2') active @endif">
                            <a id="tab_2" class="nav-link" data-bs-target="#tab_2-2" data-bs-toggle="tabajax"
                            href="{{ route("admin.settings.smtp") }}"
                                data-target="#tab_2-2" aria-controls="tab_2-2" aria-selected="true">
                                {{ trans('settings/admin_smtp_lang.settings') }}
                            </a>
                        </li>
                    @endif
                </ul>
                <div class="tab-content" id="tab_tabContent">
                    @if (auth()->user()->isAbleTo('admin-settings-show') || auth()->user()->isAbleTo('admin-settings-update')) 
                        <div id="tab_1-1" class="tab-pane @if ($tab == 'tab_1') active @endif">            
                            @yield('tab_content_1')
                        </div>
                    @endif
                    @if (auth()->user()->isAbleTo('admin-settings-smtp-update') || auth()->user()->isAbleTo('admin-settings-smtp-show')) 
                        <div id="tab_2-2" class="tab-pane @if ($tab == 'tab_2') active @endif">            
                            @yield('tab_content_2')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('foot_page')

@yield('tab_foot')
@stop

