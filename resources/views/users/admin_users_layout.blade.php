@extends('layouts.admin.default')
@section('title')
    @parent {{ $pageTitle }}
@stop
@section('head_page')
<link href="{{ asset('/assets/admin/vendor/jquery-bonsai/css/jquery.bonsai.css')}}" rel="stylesheet" />
    
@stop

@section('breadcrumb')
<li><a href="{{ url('admin/users') }}">{{ $title }}</a></li>
@yield('tab_breadcrumb')
@stop

@section('content')
@php
$disabled= isset($disabled)?$disabled : null;
@endphp
<section role="main" class="content-body card-margin">      
    <div class="mt-2">
       
        @include('layouts.admin.includes.errors')        
    </div>
   @if (!empty( $user->id))
        <div class="row">
            <div class="col-12 text-end">
                <h3> <span class="badge badge-primary p-2"><b>{{ $user->userProfile->fullName }}</b></span></h3>
                
            </div>
            @if (auth()->user()->isAbleTo("admin-users-suplant-identity") && auth()->user()->id != $user->id) 
            <div class="col-12 text-start">

                <a  class="btn btn-primary btn-xs ms-1"  data-bs-content="{{ trans('general/admin_lang.suplant')  }}" data-bs-placement="left" data-bs-toggle="popover" href="{{ route('admin.suplantar', $user->id) }} " ><i
                class="fa fa-user-secret" ></i> {{ trans('general/admin_lang.suplant')  }}</a> 
            </div>
            @endif
        </div>
    @else
        <div class="col-12 mb-5"></div>
    @endif

    <div class="row mt-2">
        @if (!empty( $user->id))
            <div class="col-12 col-md-3">
                <section class="card">
                
                    <div class="card-body">
                        
                        <div class="thumb-info mb-3">
                            <div id="fileOutput">
                                @if($user->userProfile->photo!='')
                                    <img src='{{ url('admin/profile/getphoto/'.$user->userProfile->photo) }}' id='image_ouptup' class="rounded img-fluid" alt="{{ Auth::user()->userProfile->fullName }}">
                                @else
                                    <img src="{{ asset("/assets/front/img/!logged-user.jpg") }}" class="rounded img-fluid" alt="{{ Auth::user()->userProfile->fullName }}">
                                @endif
                            </div>
                        </div>
                        <hr class="dotted short">

                        <h5 class="mb-2 mt-3">  {{ trans('profile/admin_lang.acerca_de') }}</h5>
                        <p class="text-2">
                            {{ trans('profile/admin_lang.registered_at') }} {{ Auth::user()->createdAtFormatted }}
                        </p>
                    </div>
                </section>
            </div>
        @endif
        <div class="col-12   @if (!empty( $user->id)) col-md-9 @endif">
            <div class="tabs tabs-primary">
                <ul class="nav nav-tabs" id="custom-tabs">
            
                    <li class="nav-item @if ($tab == 'tab_1') active @endif">
                        @if (empty($disabled))
                            <a id="tab_1" class="nav-link" data-bs-target="#tab_1-1" data-bs-toggle="tabajax"
                                href="{{ !empty($user->id) ? url('admin/users/' . $user->id . '/edit') : '#' }}"
                                data-target="#tab_1-1" aria-controls="tab_1-1" aria-selected="true">
                                {{ $pageTitle }}
                            </a>
                        @else
                            <a id="tab_1" class="nav-link" data-bs-target="#tab_1-1" data-bs-toggle="tabajax"
                            href="{{ !empty($user->id) ? url('admin/users/' . $user->id . '/show    ') : '#' }}"
                            data-target="#tab_1-1" aria-controls="tab_1-1" aria-selected="true">
                            {{ $pageTitle }}
                        </a>
                        @endif
                    </li>
            
                    @if (!empty($user->id) &&  Auth::user()->isAbleTo("admin-users-update") )
                        <li class="nav-item @if ($tab == 'tab_4') active @endif">
                            @if (empty($disabled))
                                <a id="tab_4" class="nav-link" data-bs-target="#tab_4-4"
                                data-bs-toggle="tabajax" href="{{ url('admin/users/personal-info/'.$user->id) }}" data-target="#tab_4-4"
                                aria-controls="tab_4-4" aria-selected="true" >
                                    {{ trans('users/admin_lang.personal_info') }}
                                </a>
                                                           
                            @else
                                <a id="tab_4" class="nav-link" data-bs-target="#tab_4-4"
                                data-bs-toggle="tabajax" href="{{ url('admin/users/personal-info/'.$user->id.'/show') }}" data-target="#tab_4-4"
                                aria-controls="tab_4-4" aria-selected="true" >
                                    {{ trans('users/admin_lang.personal_info') }}
                                </a>
                            @endif
                           
                        </li>
                    
                    @endif

                    
                    
                    @if (!empty($user->id) &&  Auth::user()->isAbleTo("admin-users-update") )
                        <li class="nav-item @if ($tab == 'tab_2') active @endif">
                            @if (empty($disabled))
                            <a id="tab_2" class="nav-link" data-bs-target="#tab_2-2"
                            data-bs-toggle="tabajax" href="{{ url('admin/users/roles/'.$user->id) }}" data-target="#tab_2-2"
                            aria-controls="tab_2-2" aria-selected="true" >
                                {{ trans('users/admin_lang.roles') }}
                            </a>
                                                        
                            @else
                            <a id="tab_2" class="nav-link" data-bs-target="#tab_2-2"
                            data-bs-toggle="tabajax" href="{{ url('admin/users/roles/'.$user->id.'/show') }}" data-target="#tab_2-2"
                            aria-controls="tab_2-2" aria-selected="true" >
                                {{ trans('users/admin_lang.roles') }}
                            </a>
                        @endif
                            
                        </li>
                    
                    @endif
                </ul>
                <div class="tab-content" id="tab_tabContent">
                    <div id="tab_1-1" class="tab-pane @if ($tab == 'tab_1') active @endif">
            
                        @yield('tab_content_1')
                    </div>
            
                    @if (!empty($user->id) &&  Auth::user()->isAbleTo("admin-users-update") )
                        <div id="tab_4-4" class="tab-pane  @if ($tab == 'tab_4') active @endif">
                            @yield('tab_content_4')
                        </div>
                    @endif
                    @if (!empty($user->id) &&  Auth::user()->isAbleTo("admin-users-update") )
                        <div id="tab_3-3" class="tab-pane  @if ($tab == 'tab_3') active @endif">
                            @yield('tab_content_3')
                        </div>
                    @endif
                    @if (!empty($user->id) &&  Auth::user()->isAbleTo("admin-users-update") )
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

