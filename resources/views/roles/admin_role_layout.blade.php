@extends('layouts.admin.default')
@section('title')
    @parent {{ $pageTitle }}
@stop
@section('head_page')
<link href="{{ asset('/assets/admin/vendor/jquery-bonsai/css/jquery.bonsai.css')}}" rel="stylesheet" />
    
@stop

@section('breadcrumb')
<li><span>{{ $title }}</span></li>
@yield('tab_breadcrumb')
@stop

@section('content')
    
<section role="main" class="content-body card-margin">      
    <div class="mt-2">
     
        @include('layouts.admin.includes.errors')

    </div>
    <div class="row">
        <div class="col-12 text-end">
            <h3> <span class="badge badge-primary p-2"><b>{{ $role->display_name }}</b></span></h3>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="tabs tabs-primary">
                <ul class="nav nav-tabs" id="custom-tabs">
            
                    <li class="nav-item @if ($tab == 'tab_1') active @endif">
                        <a id="tab_1" class="nav-link" data-bs-target="#tab_1-1" data-bs-toggle="tabajax"
                            href="{{ !empty($role->id) ? url('admin/roles/' . $role->id . '/edit') : '#' }}"
                            data-target="#tab_1-1" aria-controls="tab_1-1" aria-selected="true">
                            {{ trans('roles/admin_lang.edit') }}
                        </a>
                    </li>
            
                
                    @if (!empty($role->id))
                        <li class="nav-item @if ($tab == 'tab_2') active @endif">
                            <a id="tab_2" class="nav-link" data-bs-target="#tab_2-2"
                            data-bs-toggle="tabajax" href="{{ url('admin/roles/permissions/'.$role->id) }}" data-target="#tab_2-2"
                            aria-controls="tab_2-2" aria-selected="true" >
                                {{ trans('roles/admin_lang.permissions') }}
                            </a>
                        </li>
                    
                    @endif
                </ul>
                <div class="tab-content" id="tab_tabContent">
                    <div id="tab_1-1" class="tab-pane @if ($tab == 'tab_1') active @endif">
            
                        @yield('tab_content_1')
                    </div>
            
                    @if (!empty($role->id))
                        <div id="tab_2-2" class="tab-pane  @if ($tab == 'tab_2') active @endif">
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

