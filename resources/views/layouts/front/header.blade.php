<header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': true, 'stickyStartAt': 30, 'stickyHeaderContainerHeight': 85}">
  <div class="header-body header-body-bottom-border border-top-0">
  
    <div class="header-container container">
      <div class="header-row">
        <div class="header-column">
          <div class="header-row">
            <div class="header-logo">
              <a href="demo-cleaning-services.html">
                <img src="{{ asset('assets/front/img/demos/cleaning-services/logo.png')}}" class="img-fluid" width="123" height="32" alt="" />
              </a>
            </div>
          </div>
        </div>
        <div class="header-column justify-content-end">
          <div class="header-row">
            <div class="header-nav header-nav-links">
              <div class="header-nav-main header-nav-main-text-capitalize header-nav-main-effect-2 header-nav-main-sub-effect-1">
                <nav class="collapse">
                  <ul class="nav nav-pills" id="mainNav">
                    <li><a href="{{ url('/') }}" class="nav-link active">{{ trans('frontlayout/front_lang.menu_items.home') }}</a></li>
                   <li class="dropdown">
                      <a class="dropdown-item dropdown-toggle" href="#">
                        @if(config('app.locale')=='en') 
                        <img width="30px" src="{{ asset('assets/admin/img/en_lang.png') }}" alt="image" class="rounded-circle me-2"> 
                         @endif
                         @if(config('app.locale')=='es') 
                         <img width="30px" src="{{ asset('assets/admin/img/es_lang.png') }}" alt="image" class="rounded-circle me-2"> 
                          @endif
                        {{ trans('frontlayout/front_lang.menu_items.language') }}
                      <i class="fas fa-chevron-down"></i></a>
                      <ul class="dropdown-menu">
                       
                        <li class="@if(config('app.locale')=='en') d-none @endif">
                          <a class="dropdown-item" href="{{ url('lang/en') }}">
                            <figure class="image">
                              <img style="width: 30px !important" src="{{ asset('assets/admin/img/en_lang.png') }}" alt="image" class="rounded-circle me-2">
                              {{ trans('frontlayout/front_lang.menu_items.en_lang') }}
                            </figure>
                            </a>
                           </li>
                          <li class="@if(config('app.locale')=='es') d-none @endif">
                            <a class="dropdown-item" href="{{ url('lang/es') }}">
                              <img style="width: 30px !important" src="{{ asset('assets/admin/img/es_lang.png') }}" alt="image" class="rounded-circle me-2">
                              {{ trans('frontlayout/front_lang.menu_items.es_lang') }}  
                            </a>
                          </li>
                       
                      </ul>
                    </li>
                    @auth
                    <li><a href="{{ url('/admin/users') }}" class="nav-link">{{ trans('frontlayout/front_lang.menu_items.administration') }}</a></li>
                   
                    <li>
                      <a role="menuitem" tabindex="-1" href="{{ route('logout') }}"
                          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                          <i class="fas fa-power-off me-1 text-danger"></i> {{ trans('general/admin_lang.logout') }}
                      </a>
                    </li>

                      
                   @endauth
                   @guest
                   <li><a href="{{ route('login') }}"class="nav-link">{{ trans('frontlayout/front_lang.menu_items.login') }}</a></li>
                   <li><a href="{{ route('register') }}"class="nav-link">{{ trans('frontlayout/front_lang.menu_items.register') }}</a></li>
                    
                  
                   @endguest
                  </ul>
                </nav>
              </div>
            </div>
            <div class="feature-box feature-box-style-2 align-items-center ms-lg-4">
              <div class="feature-box-icon d-none d-sm-inline-flex">
                <img class="icon-animated" width="48" src="{{ asset('assets/front/img/demos/cleaning-services/icons/phone.svg')}}" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-tertiary position-relative bottom-3'}" />
              </div>
              <div class="feature-box-info ps-2">
                <p class="font-weight-semibold line-height-1 text-2 pb-0 mb-1">{{ trans('frontlayout/front_lang.menu_items.call_us') }}</p>
                <a href="tel:+1234567890" class="text-color-tertiary text-color-hover-primary text-decoration-none font-weight-bold line-height-1 custom-font-size-1 pb-0">800-123-4567</a>
              </div>
            </div>
            <button class="btn header-btn-collapse-nav" data-bs-toggle="collapse" data-bs-target=".header-nav-main nav">
              <i class="fas fa-bars"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>