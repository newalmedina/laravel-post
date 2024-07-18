@extends('roles.admin_role_layout')


@section('tab_head')
<link href="{{ asset('/assets/admin/vendor/jquery-bonsai/css/jquery.bonsai.css')}}" rel="stylesheet" />
<style>
   
</style>
@stop

@section('tab_breadcrumb')
<li class="breadcrumb-item active"><a href="#">{{ $pageTitle }}</a></li>
@stop

@section('tab_content_2')

<div class="row">
    <div class="col-12">
        <form id="frm_Permission_Role" action="{{ route("admin.permissions.update",$role->id) }}" method="post"  novalidate="false">
            @csrf
            @method('patch')
            <input type="hidden" name="results" id="results">
            <div class="row">

                <div class="col-lg-12">
                 
            
                    {!! "<ol id='checkboxes'>" !!}
                    <?php $actDepth = 0; ?>
            
                    @foreach($permissionsTree as $key=>$value)
            
                        @if($actDepth!=$value->depth)
                            @if($actDepth>$value->depth)
                                @for($nX=$actDepth;$nX>$value->depth; $nX--)
                                </ol>
                                </li>
                                @endfor
                            @endif
                        <?php $actDepth=$value->depth; ?>
                        @endif
            
                        @if($value->depth==0)
                            {!! "<li class='expanded'>" !!}
                        @else
                            {!! "<li>" !!}
                        @endif
            
                        @if($value->isRoot())
                            <input type='checkbox' class="general-check" id="root" value='root' />
                            <i class="fas fa-folder text-warning" style="font-size: 18px; margin-left: 5px; margin-right: 5px;"></i>
                            {{ trans('roles/admin_lang.todos') }}
                            @if($value->descendants()->count()>0)
                                {!! "<ol>" !!}
                            @else
                                {!! "</li>" !!}
                            @endif
                        @else
                            @if($value->descendants()->count()>0)
                                <input type='checkbox' class="general-check" value="{{ $value->permission["id"] }}" @if(in_array($value->permission["id"], $a_arrayPermisos)) checked @endif />
                                <i class="fas fa-folder text-warning text-tree-icon"></i>
            
                               {{-- @if(config("general.admin.allow_remove_permission_tree", false))
                                <a href="#" onclick="javascript:deleteElement('{{ url('admin/roles/permissions/'.$id.'/'.$value->permission["id"]) }}');" >
                                    <i class="fas fa-trash text-danger text-tree-icon"></i>
                                </a>
                                @endif--}}
            
                                {{ $value->permission["display_name"] }}
                                {!! "<ol>" !!}
                            @else
                                <input type='checkbox' class="general-check" value='{{ $value->permission["id"] }}' @if(in_array($value->permission["id"], $a_arrayPermisos)) checked @endif />
                                <i class="fas fa-key text-success text-tree-icon-med"></i>
            
                               {{-- @if(config("general.admin.allow_remove_permission_tree", false))
                                <a href="#" onclick="javascript:deleteElement('{{ url('admin/roles/permissions/'.$id.'/'.$value->permission["id"]) }}');" >
                                    <i class="fas fa-trash text-danger text-tree-icon"></i>
                                </a>
                                @endif--}}
            
                                {{ $value->permission["display_name"] }}&nbsp;<span class="text-tree-min">[{{ $value->permission["name"]  }}]</span>
                                {!! "</li>" !!}
                            @endif
                        @endif
            
                    @endforeach
            
                    @if($actDepth>0)
                        @for($nX=$actDepth;$nX>0; $nX--)
                            {!! "</ol>" !!}
                            {!! "</li>" !!}
                        @endfor
                    @endif
            
                    {!! "</ol>" !!}
            
                </div>
            </div>
            
            <div class="card-footer row mt-2">
                <div class="col-12  d-flex justify-content-between">

                    <a href="{{ url('admin/roles') }}" class="btn btn-default">{{ trans('general/admin_lang.back') }}</a>    
                    <button type="button" onclick="sendInfo()" class="btn btn-primary">{{ trans('general/admin_lang.save') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section("tab_foot")
<script type="text/javascript" src="{{ asset('/assets/admin/vendor/jquery-bonsai/js/jquery.bonsai.js')}}"></script>
<script type="text/javascript" src="{{ asset('/assets/admin/vendor/jquery-qubit/js/jquery.qubit.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#checkboxes').bonsai({
            expandAll: false,
            checkboxes: true
        });
    });

    function sendInfo() {
        var sendUrlId = "";



        $("#checkboxes input").each(function() {
            if(($(this).val()!='' && $(this).attr("id")!='root') && ($(this).is(":checked") || $(this).is(":indeterminate"))) {
                if(sendUrlId!='') sendUrlId+=",";
                sendUrlId+=$(this).val();
            }
        });

        if(sendUrlId!='') {
            $("#results").val(sendUrlId);
            $("#frm_Permission_Role").submit();
        } else {
            $("#modal_alert").addClass('modal-warning');
            $("#alertModalBody").html("<i class='fas fa-times-circle text-danger' style='font-size: 64px; float: left; margin-right:15px;'></i> {!! trans('roles/lang.seleccione_un_permiso') !!}");
            $("#modal_alert").modal('toggle');
        }

    }
</script>

@stop