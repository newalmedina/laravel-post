 @php
     $activeColor="#0088CC";
     
 @endphp
 <!-- start: sidebar -->
 <aside id="sidebar-left" class="sidebar-left">

    <div class="sidebar-header">
        <div class="sidebar-title">
            Menú navegación
        </div>
        <div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <div class="nano has-scrollbar">
        <div class="nano-content" tabindex="0" style="right: -17px;">
            <nav id="menu" class="nav-main" role="navigation">

                <ul class="nav nav-main">
                    @if(Auth::user()->isAbleTo("admin-dashboard-show") )
                        <li class="@if (Request::is('admin/dashboard*') ) nav-active @endif">
                            <a class="nav-link" @if (Request::is('admin/dashboard*')) style="color:{{ $activeColor }}" @endif href="{{ url('admin/dashboard') }}">
                                <i class="fas fa-home" aria-hidden="true"></i>
                                <span>{{ trans('dashboard/admin_lang.dashboard') }}</span>
                            </a>                        
                        </li>
                    @endif
                    @if(Auth::user()->isAbleTo("admin-roles") || Auth::user()->isAbleTo("admin-roles") )
                        <li class="nav-parent 
                            @if (Request::is('admin/users*') ||
                                Request::is('admin/roles*')
                            ) 
                               nav-active
                               nav-expanded
                            @endif">
                            <a class="nav-link" href="#">
                                <i class="fas fa-user" aria-hidden="true"></i>
                                <span>{{ trans('users/admin_lang.users') }}</span>
                            </a>
                            <ul class="nav nav-children" style="">
                                @if(Auth::user()->isAbleTo("admin-users"))
                                    <li  @if (Request::is('admin/users*')) class="nav-active" @endif>                       
                                        <a class="nav-link" href="{{ url('admin/users') }}">
                                            <i class="fas fa-users" aria-hidden="true"></i>
                                            <span>{{ trans('users/admin_lang.users_management') }}</span>
                                        </a>                        
                                    </li>
                                @endif
                                @if(Auth::user()->isAbleTo("admin-roles"))
                                    <li  @if (Request::is('admin/roles*')) class="nav-active" @endif>
                            
                                        <a class="nav-link" href="{{ url('admin/roles') }}">
                                            <i class="fas fa-key" aria-hidden="true"></i>
                                            <span>{{ trans('roles/admin_lang.roles') }}</span>
                                        </a>                        
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if(Auth::user()->isAbleTo("admin-provinces") || 
                    Auth::user()->isAbleTo("admin-municipios") || 
                    Auth::user()->isAbleTo("admin-medical-specializations") || 
                    Auth::user()->isAbleTo("admin-insurance-carriers") || 
                    Auth::user()->isAbleTo("admin-services") || 
                    Auth::user()->isAbleTo("admin-diagnosis") )
                        <li class="nav-parent 
                            @if (Request::is('admin/provinces*') ||
                                Request::is('admin/municipios*') ||
                                Request::is('admin/services*') ||
                                Request::is('admin/medical-specializations*') ||
                                Request::is('admin/insurance-carriers*') ||
                                Request::is('admin/diagnosis*')
                            ) 
                               nav-active
                               nav-expanded
                            @endif">
                            <a class="nav-link" href="#">
                                <i class="fas fa-table" aria-hidden="true"></i>
                                <span>{{ trans('table_system/admin_lang.table_system')  }}</span>
                            </a>
                            <ul class="nav nav-children" style="">
                                @if(Auth::user()->isAbleTo("admin-provinces"))
                                    <li  @if (Request::is('admin/provinces*')) class="nav-active" @endif>                       
                                        <a class="nav-link" href="{{ url('admin/provinces') }}">
                                            <i class="fas fa-location-arrow" aria-hidden="true"></i>
                                            <span>{{ trans('provinces/admin_lang.provinces') }}</span>
                                        </a>                        
                                    </li>
                                @endif
                                @if(Auth::user()->isAbleTo("admin-municipios"))
                                    <li  @if (Request::is('admin/municipios*')) class="nav-active" @endif>
                            
                                        <a class="nav-link" href="{{ url('admin/municipios') }}">
                                            <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                            <span>{{ trans('municipios/admin_lang.municipios') }}</span>
                                        </a>                        
                                    </li>
                                @endif
                                @if(Auth::user()->isAbleTo("admin-services"))
                                    <li  @if (Request::is('admin/services*')) class="nav-active" @endif>
                            
                                        <a class="nav-link" href="{{ url('admin/services') }}">
                                            <i class="fas fa-list" aria-hidden="true"></i>
                                            <span>{{ trans('services/admin_lang.services') }}</span>
                                        </a>                        
                                    </li>
                                @endif
                                @if(Auth::user()->isAbleTo("admin-diagnosis"))
                                    <li  @if (Request::is('admin/diagnosis*')) class="nav-active" @endif>
                            
                                        <a class="nav-link" href="{{ url('admin/diagnosis') }}">
                                            <i class="fas fa-stethoscope" aria-hidden="true"></i>
                                            <span>{{ trans('diagnosis/admin_lang.diagnosis') }}</span>
                                        </a>                        
                                    </li>
                                @endif
                                @if(Auth::user()->isAbleTo("admin-medical-specializations"))
                                    <li  @if (Request::is('admin/medical-specializations*')) class="nav-active" @endif>
                            
                                        <a class="nav-link" href="{{ url('admin/medical-specializations') }}">
                                            <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                                            <span>{{ trans('medical-specializations/admin_lang.medical-specializations') }}</span>
                                        </a>                        
                                    </li>
                                @endif
                                @if(Auth::user()->isAbleTo("admin-insurance-carriers"))
                                    <li  @if (Request::is('admin/insurance-carriers*')) class="nav-active" @endif>
                                        <a class="nav-link" href="{{ url('admin/insurance-carriers') }}">
                                            <i class="fas fa-house-damage" aria-hidden="true"></i>
                                            <span>{{ trans('insurance-carriers/admin_lang.insurance-carriers') }}</span>
                                        </a>                        
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if(Auth::user()->isAbleTo("admin-centers")  )
                        <li class="@if (Request::is('admin/centers*') ) nav-active @endif">
                            <a class="nav-link" @if (Request::is('admin/centers*')) style="color:{{ $activeColor }}" @endif  href="{{ url('/admin/centers') }}">
                                <i class="fas fa-hospital" aria-hidden="true"></i>
                                <span>{{ trans('centers/admin_lang.centers') }}</span>
                            </a>                        
                        </li>
                    @endif
                    @if(Auth::user()->isAbleTo("admin-clinic-personal") && Auth::user()->hasSelectedCenter()  )
                        <li class="@if (Request::is('admin/clinic-personal*') ) nav-active @endif">
                            <a class="nav-link" @if (Request::is('admin/clinic-personal*')) style="color:{{ $activeColor }}" @endif  href="{{ url('/admin/clinic-personal') }}">
                                <i class="fas fa-user-md" aria-hidden="true"></i>
                                <span>{{ trans('clinic-personal/admin_lang.clinic-personal') }}</span>
                            </a>                        
                        </li>
                    @endif
                    
                    @if(Auth::user()->isAbleTo("admin-patients") && Auth::user()->hasSelectedCenter()  )
                        <li class="@if (Request::is('admin/patients*') ) nav-active @endif">
                            <a class="nav-link" @if (Request::is('admin/patients*')) style="color:{{ $activeColor }}" @endif  href="{{ url('/admin/patients') }}">
                                <i class="fas fa-user-injured" aria-hidden="true"></i>
                                <span>{{ trans('patients/admin_lang.patients') }}</span>
                            </a>                        
                        </li>
                    @endif
                    
                    @if(Auth::user()->isAbleTo("admin-settings")  )
                        <li class="@if (Request::is('admin/settings*') ) nav-active @endif">
                            <a class="nav-link" @if (Request::is('admin/settings*')) style="color:{{ $activeColor }}" @endif  href="{{ url('/admin/settings') }}">
                                <i class="fas fa-cog" aria-hidden="true"></i>
                                <span>{{ trans('settings/admin_lang.settings') }}</span>
                            </a>                        
                        </li>
                    @endif
                  
                    {{-- <li >
                       
                        <a class="nav-link" href="{{ url('/') }}">
                            <i class="fas fa-globe" aria-hidden="true"></i>
                            <span>{{ trans('general/admin_lang.go_web') }}</span>
                        </a>                        
                    </li> --}}
                </ul>
            </nav>
        </div>

        <script>
            // Maintain Scroll Position
            if (typeof localStorage !== 'undefined') {
                if (localStorage.getItem('sidebar-left-position') !== null) {
                    var initialPosition = localStorage.getItem('sidebar-left-position'),
                        sidebarLeft = document.querySelector('#sidebar-left .nano-content');

                    sidebarLeft.scrollTop = initialPosition;
                }
            }
        </script>

    <div class="nano-pane" style="opacity: 1; visibility: visible; display: none;"><div class="nano-slider" style="height: 381px; transform: translate(0px);"></div></div></div>

</aside>
<!-- end: sidebar -->