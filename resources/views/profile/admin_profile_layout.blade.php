@extends('layouts.admin.default')
@section('title')
    @parent {{ $pageTitle }}
@stop
@section('head_page')
<link href="{{ asset('/assets/admin/vendor/jquery-bonsai/css/jquery.bonsai.css')}}" rel="stylesheet" />
    
@stop

@section('breadcrumb')
<li><a href="{{ url('admin/profile') }}">{{ $title }}</a></li>
@yield('tab_breadcrumb')
@stop

@section('content')
    
<section role="main" class="content-body card-margin">      
    <div class="mt-2">
         @include('layouts.admin.includes.modals')
      
        @include('layouts.admin.includes.errors')   
    </div>
   @if (!empty( $user->id))
        <div class="row">
            <div class="col-12 text-end">
                <h3> <span class="badge badge-primary p-2"><b>{{ $user->userProfile->fullName }}</b></span></h3>
            </div>
        </div>
    @else
        <div class="col-12 mb-5"></div>
    @endif

    <div class="row ">
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


                        <div class="thumb-info-title">
                            <span class="thumb-info-inner">{{ Auth::user()->userProfile->fullName }}</span>
                            <span class="thumb-info-type"> {{ implode(",",Auth::user()->roles->pluck('display_name')->toArray()) }}</span>
                        </div>
                    </div>

                    <div id="remove" class="text-danger" style="@if($user->userProfile->photo=='') display: none; @endif cursor: pointer; text-align: center;"><i class="fa fa-times" aria-hidden="true"></i> {{ trans('profile/admin_lang.quit_image') }} </div>


                    <hr class="dotted short">

                    <h5 class="mb-2 mt-3">  {{ trans('profile/admin_lang.acerca_de') }}</h5>
                    <p class="text-2">
                        {{ trans('profile/admin_lang.registered_at') }} {{ Auth::user()->createdAtFormatted }}
                    </p>
                </div>
            </section>
        </div>
        <div class="col-12 col-md-9  ">
            <div class="tabs tabs-primary">
                <ul class="nav nav-tabs" id="custom-tabs">
            
                    <li class="nav-item @if ($tab == 'tab_1') active @endif">
                        <a id="tab_1" class="nav-link" data-bs-target="#tab_1-1" data-bs-toggle="tabajax"
                            href="{{ !empty($user->id) ? url('admin/profile/') : '#' }}"
                            data-target="#tab_1-1" aria-controls="tab_1-1" aria-selected="true">
                            {{ trans('profile/admin_lang.general_information') }}
                        </a>
                    </li>                
                   
                    <li class="nav-item @if ($tab == 'tab_2') active @endif">
                        <a id="tab_2" class="nav-link" data-bs-target="#tab_2-2"
                        data-bs-toggle="tabajax" href="{{ url('admin/profile/personal-info/') }}" data-target="#tab_2-2"
                        aria-controls="tab_2-2" aria-selected="true" >
                            {{ trans('profile/admin_lang.personal_information') }}
                        </a>
                    </li>
                    @if (Auth::user()->isDoctor() )
                        
                    <li class="nav-item @if ($tab == 'tab_3') active @endif">
                        <a id="tab_3" class="nav-link" data-bs-target="#tab_3-3"
                        data-bs-toggle="tabajax" href="{{ url('admin/profile/clinic-training/') }}" data-target="#tab_3-3"
                        aria-controls="tab_3-3" aria-selected="true" >
                            {{ trans('profile/admin_lang.clinic_training') }} 
                        </a>
                    </li>
                @endif
                </ul>
                <div class="tab-content" id="tab_tabContent">
                    <div id="tab_1-1" class="tab-pane @if ($tab == 'tab_1') active @endif">
            
                        @yield('tab_content_1')
                    </div>
            
                        <div id="tab_2-2" class="tab-pane  @if ($tab == 'tab_2') active @endif">
                            @yield('tab_content_2')
                        </div>

                        <div id="tab_3-3" class="tab-pane  @if ($tab == 'tab_3') active @endif">
                            @yield('tab_content_3')
                        </div>
                    
            
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('foot_page')
<script>
     $(document).ready(function() {
            $("#btnSelectImage").click(function() {
                $('#profile_image').trigger('click');
            });

            $("#profile_image").change(function(){
                getFileName();
                readURL(this);
            });

            $("#remove").click(function() {
                "@if($user->userProfile->photo!='')"
                    var strBtn = "";

                    $("#confirmModalLabel").html("{{ trans('general/admin_lang.delete') }}");
                    $("#confirmModalBody").html("<div class='d-flex align-items-center'><i class='fas fa-question-circle text-success' style='font-size: 64px; float: left; margin-right:15px;'></i><label class='text-primary' style='font-size: 18px'>{{ trans('general/admin_lang.delete_question_image') }}</label></div>");
                    strBtn+= '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('general/admin_lang.close') }}</button>';
                    strBtn+= '<button type="button" class="btn btn-primary" onclick="javascript:deleteinfo();">{{ trans('general/admin_lang.yes_delete') }}</button>';
                    $("#confirmModalFooter").html(strBtn);
                    $('#modal_confirm').modal('toggle');
                "@else"
                    $('#nombrefichero').val('');
                    $('#profile_image').val("");
                    $('#fileOutput').html('<img src="{{ asset("/assets/front/img/!logged-user.jpg") }}" class="rounded img-fluid" alt="{{ Auth::user()->userProfile->fullName }}">');
                    $("#remove").css("display", "none");
                
                "@endif"
            });
      });

      function deleteinfo() {
        let url ="{{ url('admin/profile/delete-image/') }}/{{ $user->id }}"
        $.ajax({
            url     : url,
            type    : 'POST',
            "headers": {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
            data: {_method: 'delete'},
            success : function(data) {
                $('#modal_confirm').modal('hide');
                if(data) {
                    $('#nombrefichero').val('');
                    $('#profile_image').val("");
                    $('#fileOutput').html('<img src="{{ asset("/assets/front/img/!logged-user.jpg") }}" class="rounded img-fluid" alt="{{ Auth::user()->userProfile->fullName }}">');
                    $("#remove").css("display", "none");
                    toastr.success( data.msg)
                } else {
                    $("#modal_alert").addClass('modal-danger');
                    $("#alertModalBody").html("<i class='fas fa-bug text-danger' style='font-size: 64px; float: left; margin-right:15px;'></i> {{ trans('general/admin_lang.errorajax') }}");
                    $("#modal_alert").modal('toggle');
                }
                return false;
            }

        });
        return false;
    }   

      function getFileName() {
            $('#nombrefichero').val($('#profile_image')[0].files[0].name);
            $("#delete_photo").val('1');
            $("#contenedor-remove").css("display","");
        }
        
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#fileOutput').html("<img src='"+e.target.result+"' id='image_ouptup' width='100%' alt=''>");
                    $("#remove").css("display","block");
                  //  $('#image_ouptup').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>

@yield('tab_foot')
@stop

