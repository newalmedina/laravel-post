<ul class="notifications">
    <li>
        <a href="#" class=" " data-bs-toggle="dropdown" aria-expanded="false">
            <figure class="image pt-2">
                @if(config('app.locale')=='en') 
                    <img width="30px" src="{{ asset('assets/admin/img/en_lang.png') }}" alt="image" class="rounded-circle"> 
                @endif
                @if(config('app.locale')=='es') 
                    <img width="30px" src="{{ asset('assets/admin/img/es_lang.png') }}" alt="image" class="rounded-circle me-2"> 
                @endif
             </figure>
    
        </a>
     
        <div class="dropdown-menu notification-menu large" style="">
            <div class="notification-title">
                {{ trans('general/admin_lang.lang.lang') }}
            </div>

            <div class="content">
                <ul>
                    <li class="@if(config('app.locale')=='en') d-none  @endif">
                        <a href="{{ url('lang/en') }}" class="clearfix d-flex align-items-center">
                            <figure class="image">
                                <img width="30px" src="{{ asset('assets/admin/img/en_lang.png') }}" alt="image" class="rounded-circle">
                            </figure>
                            <span class="title">  {{ trans('general/admin_lang.lang.en') }}</span>
                        </a>
                    </li>
                    <li  class="@if(config('app.locale')=='es') d-none  @endif">
                        <a href="{{ url('lang/es') }}" class="clearfix d-flex align-items-center">
                            <figure class="image">
                                <img width="30px" src="{{ asset('assets/admin/img/es_lang.png') }}" alt="image" class="rounded-circle">
                            </figure>
                            <span class="title">  {{ trans('general/admin_lang.lang.es') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </li>
</ul>

@php $locale = session()->get('locale'); @endphp
@switch($locale)
@case('en')
{{-- <imgsrc="asset('assets/admin/img/en.png') " width="25px"> --}}          
@break

@default
{{-- <img src="{{asset('assets/admin/img/es.png')}}" width="25px">   --}}   
@endswitch  