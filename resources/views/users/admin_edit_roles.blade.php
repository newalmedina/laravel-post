@extends('users.admin_users_layout')


@section('tab_head')
   <style>
    .role-selected{
        cursor: pointer;
    }
   </style>
@stop

@section('tab_breadcrumb')
    <li class="breadcrumb-item active"><a href="#">{{ $pageTitle }}</a></li>
@stop

@section('tab_content_2')
@php
$disabled= isset($disabled)?$disabled : null;
@endphp
<div class="row">
    
    <div class="col-12">
        <form id="formData" action=" {{ route("admin.users.updateRoles",$user->id) }}" method="post"  novalidate="false">
            @csrf   
            @method('patch') 
              
            <div class="card-body">
                <div class="row">
                    @foreach ($roles as $role)
                        <div class="col-12 col-md-4">
                            <section data-id="{{ $role->id }}" class="card  mb-4 role-selected @if($user->hasRole($role->name)) card-success @else card-default @endif">
                                <header class="card-header text-center">
                                    <h2 class="card-title">{{ $role->display_name }}</h2>
                                </header>
                                <div class="card-body">
                                    <div class="row d-flex text-center">
                                        <div class="col-12 col-md-12 mb-2"> <i class="fas fa-user-plus fa-4x"></i></div>
                                        <div class="col-12 col-md-12">{{ $role->description }}</div>
                                    </div>
                                </div>
                            </section>
                        </div> 
                    @endforeach   
                    <input type="hidden" name="role_ids"  id="role_ids">
                </div>                
            </div>
            <div class="card-footer row">
                <div class="col-12  d-flex justify-content-between">

                    <a href="{{ url('admin/users') }}" class="btn btn-default">{{ trans('general/admin_lang.back') }}</a>
                    @if (empty($disabled))
                     <button type="submit" class="btn btn-primary">{{ trans('general/admin_lang.save') }}</button>  
                     @endif    
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section("tab_foot")
<script>
    $(document).ready(function(){
        selectedRoles();
    }); 

    $(document).on("click",".role-selected",function() {
        if($(this).hasClass("card-success")) {
            $(this).removeClass("card-success");
            $(this).addClass("card-default");
        } else {
            $(this).removeClass("card-default");
            $(this).addClass("card-success");
        }
        selectedRoles();
    });

    function selectedRoles(){
        $("#role_ids").val("");
        $ids="";
        $( ".role-selected" ).each(function() {
            if($(this).hasClass("card-success")) {
                if ($ids=="") {
                    $ids+=$(this).data("id");
                } else {
                    $ids+=","+$(this).data("id");
                }
            }
        }); 
        $("#role_ids").val( $ids );
    }
</script>
@stop