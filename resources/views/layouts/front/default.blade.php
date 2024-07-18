<!DOCTYPE html>
<html>
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">	

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

		<meta name="keywords" content="HTML5 Template" />
		<meta name="description" content="Porto - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Favicon -->
		<link rel="shortcut icon" href="{{ asset('assets/front/img/favicon.ico')}}" type="image/x-icon" />
		<link rel="apple-touch-icon" href="{{ asset('assets/front/img/apple-touch-icon.png')}}">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

		<!-- Web Fonts  -->
		<link id="googleFonts" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800%7CRoboto+Slab:300,400,700,900&display=swap" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="{{ asset('assets/front/vendor/bootstrap/css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{ asset('assets/front/vendor/fontawesome-free/css/all.min.css')}}">
		<link rel="stylesheet" href="{{ asset('assets/front/vendor/animate/animate.compat.css')}}">
		<link rel="stylesheet" href="{{ asset('assets/front/vendor/simple-line-icons/css/simple-line-icons.min.css')}}">
		<link rel="stylesheet" href="{{ asset('assets/front/vendor/owl.carousel/assets/owl.carousel.min.css')}}">
		<link rel="stylesheet" href="{{ asset('assets/front/vendor/owl.carousel/assets/owl.theme.default.min.css')}}">
		<link rel="stylesheet" href="{{ asset('assets/front/vendor/magnific-popup/magnific-popup.min.css')}}">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="{{ asset('assets/front/css/theme.css')}}">
		<link rel="stylesheet" href="{{ asset('assets/front/css/theme-elements.css')}}">
		<link rel="stylesheet" href="{{ asset('assets/front/css/theme-blog.css')}}">
		<link rel="stylesheet" href="{{ asset('assets/front/css/theme-shop.css')}}">

		<!-- Demo CSS -->
		<link rel="stylesheet" href="{{ asset('assets/front/css/demos/demo-cleaning-services.css')}}">

		<!-- Skin CSS -->
		<link id="skinCSS" rel="stylesheet" href="{{ asset('assets/front/css/skins/skin-cleaning-services.css')}}">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="{{ asset('assets/front/css/custom.css')}}">

		<!-- Head Libs -->
		<script src="{{ asset('assets/front/vendor/modernizr/modernizr.min.js')}}"></script>
		
		<link rel="stylesheet" href="{{ asset('assets/admin/vendor/toast/toast.min.css')}}">
    	@yield('head_page')
	</head>
	<body class="alternative-font-4 loading-overlay-showing img-background" data-plugin-page-transition data-loading-overlay data-plugin-options="{'hideDelay': 100}">

        <div class="loading-overlay">
			<div class="bounce-loader">
				<div class="bounce1"></div>
				<div class="bounce2"></div>
				<div class="bounce3"></div>
			</div>
        </div>
		<div class="body">
            
	       {{-- @include('layouts.front.header') --}}
         @yield('content')
         {{-- @include('layouts.front.footer') --}}
			
    </div>
    
    <!-- Vendor -->
    <script src="{{ asset('assets/front/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/front/vendor/jquery.appear/jquery.appear.min.js')}}"></script>
    <script src="{{ asset('assets/front/vendor/jquery.easing/jquery.easing.min.js')}}"></script>
    <script src="{{ asset('assets/front/vendor/jquery.cookie/jquery.cookie.min.js')}}"></script>
    <script src="{{ asset('assets/front/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/front/vendor/jquery.validation/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('assets/front/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js')}}"></script>
    <script src="{{ asset('assets/front/vendor/jquery.gmap/jquery.gmap.min.js')}}"></script>
    <script src="{{ asset('assets/front/vendor/lazysizes/lazysizes.min.js')}}"></script>
    <script src="{{ asset('assets/front/vendor/isotope/jquery.isotope.min.js')}}"></script>
    <script src="{{ asset('assets/front/vendor/owl.carousel/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('assets/front/vendor/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{ asset('assets/front/vendor/vide/jquery.vide.min.js')}}"></script>
    <script src="{{ asset('assets/front/vendor/vivus/vivus.min.js')}}"></script>

    <!-- Theme Base, Components and Settings -->
    <script src="{{ asset('assets/front/js/theme.js')}}"></script>

    <!-- Current Page Vendor and Views -->
    <script src="{{ asset('assets/front/js/views/view.contact.js')}}"></script>

    <!-- Demo -->
    <script src="{{ asset('assets/front/js/demos/demo-cleaning-services.js')}}"></script>

    <!-- Theme Custom -->
    <script src="{{ asset('assets/front/js/custom.js')}}"></script>

    <!-- Theme Initialization Files -->
    <script src="{{ asset('assets/front/js/theme.init.js')}}"></script>
	<script src="{{ asset('assets/admin/vendor/toast/toast.min.js')}}"></script>
<script type="text/javascript" src="{{ asset("assets/admin/vendor/tinymce/tinymce.min.js") }}">       </script>
	<script>
		var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
		var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl)
		})
	</script>
    @yield('foot_page')
  </body>
</html>
    