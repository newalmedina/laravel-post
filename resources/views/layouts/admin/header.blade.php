   <!-- start: header -->
   <header class="header">
    <div class="logo-container">
        <a href="../4.0.0" class="logo">
        @php
              $setting =\App\Services\SettingsServices::getGeneral();
        @endphp
        @if(!empty($setting->image))
                <img src='{{ url('admin/settings/get-image/'.$setting->image) }}' class="rounded-circle shadow-4-strong" alt="Porto Admin" width="75" height="35">
            @else
                <img src="{{ asset('assets/admin/img/logo.png')}}"  class="rounded-circle shadow-4-strong" alt="Porto Admin" width="75" height="35">
            @endif
        </a>
        <div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
        </div>
        
        
    </div>

    <!-- start: search & user box -->
    <div class="header-right">
        {{-- <span class="separator"></span>
                  @include('layouts.admin.includes.locale')
       --}}
       @if(session()->has("original-user-suplantar"))
            <div id="userbox" class="userbox">
        
                <a  class="btn btn-primary btn-sm ms-1" href="{{ route('admin.revertirSuplnatar') }}" ><i
                class="fa fa-user-secret fa-lg"></i> Quitar Suplantación
                </a>     
    
            </div> 
        @endif
       
       @if (!empty(auth()->user()->userProfile->center ))
       <div id="userbox" class="userbox">
     
        <b class="text-secondary">
            <i class="fas fa-hospital"></i>
               <i>
                  {{ auth()->user()->userProfile->center->name }}
               </i>
           </b>        
       
        </div> 
     
       @endif
       
        <span class="separator"></span>

        <div id="userbox" class="userbox">
          
            <a href="#" data-bs-toggle="dropdown" aria-expanded="false" class="">
                <figure class="profile-picture">

                    @if(Auth::user()->userProfile->photo!='')
                        <img src='{{ url('admin/profile/getphoto/'.Auth::user()->userProfile->photo) }}' id='image_ouptup' class="rounded-circle" alt="{{ Auth::user()->userProfile->fullName }}">
                    @else
                        <img src="{{ asset("/assets/front/img/!logged-user.jpg") }}" class="rounded-circle"   alt="{{ Auth::user()->userProfile->fullName }}">
                    @endif
                    </figure>
                <div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
                    <span class="name">{{ Auth::user()->userProfile->fullName }}</span>
                    <span class="role">{{ implode(",",Auth::user()->roles->pluck('display_name')->toArray()) }}</span>
                </div>

                <i class="fa custom-caret"></i>
            </a>

            <div class="dropdown-menu" style="">
                <ul class="list-unstyled mb-2">
                    <li class="divider"></li>
                    <li>
                        <a role="menuitem" tabindex="-1" href="{{ url('admin/profile') }}"><i class="bx bx-user-circle"></i> {{ trans('general/admin_lang.my_profile') }}</a>
                    </li>
                   
                    @if(Auth::user()->isAbleTo("admin-users-change-center")  )
                    <li>
                        <a role="menuitem" tabindex="-1" href="#" data-bs-toggle="modal" data-bs-target="#modalChangeCenter"><i class="bx bx-building"></i> {{ trans('centers/admin_lang.change_centers') }}</a>
                          
                    </li>
                    @endif
                    <li>                      
                        <a role="menuitem" tabindex="-1" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-power-off"></i> {{ trans('general/admin_lang.logout') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end: search & user box -->
</header>
<!-- end: header -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>