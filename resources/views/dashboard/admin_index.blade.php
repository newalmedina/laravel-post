@extends('layouts.admin.default')
@section('title')
    @parent {{ $pageTitle }}
@stop
@section('head_page')
<link href="{{ asset('/assets/admin/vendor/jquery-bonsai/css/jquery.bonsai.css')}}" rel="stylesheet" />
    
@stop

@section('breadcrumb')
<li><span>{{ $title }}</span></li>
@stop

@section('content')
<section role="main" class="content-body card-margin">
      
    <!-- start: page -->
   <div class="mt-3">
    <h2>Hola {{ Auth::user()->userProfile->fullName }}, como te sientes?</h2>

    @include('layouts.admin.includes.errors')
   </div>
   
    <!-- end: page -->
</section>   
@endsection
@section('foot_page')
@stop