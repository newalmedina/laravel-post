<!DOCTYPE HTML>
<html class="fixed js flexbox flexboxlegacy no-touch csstransforms csstransforms3d no-overflowscrolling gecko win js no-mobile-device custom-scroll" style=""><head>

    <!-- Basic -->
    <meta charset="UTF-8">

    <title>
        @section('title')
            @php
                    $setting =\App\Services\SettingsServices::getGeneral();
            @endphp
            @if(!empty($setting->site_name))
                {{ $setting->site_name }} ::
            @else
            {{ config('app.name', '') }} ::
                
            @endif
        @show
    </title>
    <meta name="keywords" content="HTML5 Admin Template">
    <meta name="description" content="Porto Admin - Responsive HTML5 Template">
    <meta name="author" content="okler.net">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->

    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/animate/animate.compat.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/font-awesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/boxicons/css/boxicons.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/magnific-popup/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css')}}">

 

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/custom.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/toast/toast.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
   <!-- Theme CSS -->
   <link rel="stylesheet" href="{{ asset('assets/admin/css/theme.css')}}">

   <!-- Skin CSS -->
   <link rel="stylesheet" href="{{ asset('assets/admin/css/skins/default.css')}}">
    <!-- Head Libs -->
    <script src="{{ asset('assets/admin/vendor/modernizr/modernizr.js')}}"></script>
    <style>
    /* Estilos personalizados para bootstrap-select */
    .bootstrap-select .btn {
      width: 100%;
      padding: 0.375rem 0.75rem;
       height: 38px;
        line-height: inherit;
      color: #495057;
      background-color: #fff;
      background-clip: padding-box;
      border: 1px solid #ced4da;
      border-radius: 0.25rem;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .bootstrap-select .dropdown-toggle::after {
      display: none;
    }
    .bootstrap-select .dropdown-toggle::before {
      content: '\f107';
      font-family: "Font Awesome 5 Free";
      font-weight: 900;
      padding-right: 0.5em;
    }
        .select2-container--default .select2-selection--single {
        /* Ajusta la altura a tu preferencia */
        height: 38px;
        line-height: inherit;
        
        display: flex;
        align-items: center;
    }
    .dataTables_filter{
        margin-right: 54px !important;
        margin-bottom: 30px !important;
    }
    .toggle-switch{
        width: 55px !important;
        height: 25px !important;
    }
    .general-check{
        width: 18px !important;
        height: 18px !important;
    }
    </style>
    @livewireStyles
    
    @yield('head_page')

</head>
<body>
    <section class="body">

     @include('layouts.admin.header')
     
     <div class="inner-wrapper">
            @include('layouts.admin.sidebar')
           
            <header class="page-header">
                <h2>{{ $pageTitle  ?? "Page Title"}}</h2>
        
                <div class="right-wrapper text-end">
                    <ol class="breadcrumbs">
                        <li>
                        
                            <a href="{{ url('admin/dashboard') }}">
                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        @section('breadcrumb')
                        @show
                    </ol>
        
                    <a class="sidebar-right-toggle" ></a>
                </div>
            </header>
          
            @yield('content')
        </div>

    </section>

    @livewireScripts
    
    <!-- Vendor -->
    

    <script src="{{ asset('assets/admin/vendor/jquery/jquery.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/jquery-browser-mobile/jquery.browser.mobile.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/popper/umd/popper.min.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/common/common.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/nanoscroller/nanoscroller.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/magnific-popup/jquery.magnific-popup.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/jquery-placeholder/jquery.placeholder.js')}}"></script>

    <!-- Specific Page Vendor -->
    <script src="{{ asset('assets/admin/vendor/autosize/autosize.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js')}}"></script>

    <!-- Theme Base, Components and Settings -->
    <script src="{{ asset('assets/admin/js/theme.js')}}"></script>

    <!-- Theme Custom -->
    <script src="{{ asset('assets/admin/js/custom.js')}}"></script>

    <!-- Theme Initialization Files -->
    <script src="{{ asset('assets/admin/js/theme.init.js')}}"></script><a class="scroll-to-top hidden-mobile" href="#"><i class="fas fa-chevron-up"></i></a>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/admin/vendor/select2/select2.min.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/toast/toast.min.js')}}"></script>
    <!-- Latest compiled and minified JavaScript -->

    <script>
        //  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        // var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        // return new bootstrap.Tooltip(tooltipTriggerEl)
        // })
	</script>
    @include('layouts.admin.includes.success')
   
    @yield('foot_page')
    @stack('scripts')
</body></html>