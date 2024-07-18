@extends('layouts.admin.default')
@section('title')
    @parent {{ $pageTitle }}
@stop
@section('head_page')
<link href="{{ asset('/assets/admin/vendor/jquery-bonsai/css/jquery.bonsai.css')}}" rel="stylesheet" />
    
@stop

@section('breadcrumb')
<li><a href="{{ url('admin/categories') }}">{{ $title }}</a></li>
<li class="breadcrumb-item active">
        <span>
            {{ $pageTitle }} 
          </span>
    </li>
@stop

@section('content')
@php
$disabled= isset($disabled)?$disabled : null;
@endphp
<section role="main" class="content-body card-margin">      
    <div class="mt-2">
         @include('layouts.admin.includes.modals')
      
        @include('layouts.admin.includes.errors')   
    </div>
    <div class="row">
        <div class="col">
            <section class="card card-featured-top card-featured-primary">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle=""></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss=""></a>
                    </div>

                    <h2 class="card-title">{{ trans("general/admin_lang.general_info") }}</h2>
                </header>
                

                <div class="card-body">  
                    <form id="formData" enctype="multipart/form-data" action="@if(empty($category->id)) {{ route("admin.categories.store") }} @else {{ route("admin.categories.update",$category->id) }} @endif" method="post"  novalidate="false">
                        @csrf       
                       
                        @if(empty($category->id))  
                            @method('post')
                        @else   
                            @method('patch') 
                        @endif
                          
                        <div class="card-body">
                            <div class="row form-group mb-3">
                                <div class="col-12 ">   
                                 
                                    <div class="form-group">
                                        <label class='text-primary' for="name"> {{ trans('categories/admin_lang.fields.name') }} <span class="text-danger">*</span> </label>
                                        <input value="{{!empty($category->name) ? $category->name :null }}" type="text" {{ $disabled }} class="form-control" name="name"  placeholder="{{ trans('categories/admin_lang.fields.name_helper') }}">
                                    </div>
                                </div>          
                            </div>                           
                            <div class="row form-group mb-3">
                                <div class="col-12 ">   
                                 
                                    <div class="form-group">
                                        <label class='text-primary' for="name"> {{ trans('categories/admin_lang.fields.description') }}  </label>
                                        <textarea name="description" class="form-control textarea" id="description" cols="30" rows="10" placeholder="{{ trans('categories/admin_lang.fields.description_helper') }}">{{ $category->description }}</textarea>
                                    </div>
                                </div>          
                            </div>                           
                          
                            <div class="row form-group mb-3">
                                <div class="col-12 ">                     
                                    <div class="form-group">
                                        <label class='text-primary' for="active"> {{ trans('categories/admin_lang.fields.active') }}</label>
                                        <div class="form-check form-switch">
                                            <input  {{ $disabled }} class="form-check-input toggle-switch" @if($category->active==1) checked @endif value="1" name="active" type="checkbox" id="active">
                                        </div>                           
                                    </div>
                                </div>                    
                                                 
                            </div>                
                        </div>
                        <div class="card-footer row">
                            <div class="col-12  d-flex justify-content-between">
            
                                <a href="{{ url('admin/categories') }}" class="btn btn-default">{{ trans('general/admin_lang.back') }}</a>
                                @if (empty( $disabled ))
                                    <button type="submit" class="btn btn-primary">{{ trans('general/admin_lang.save') }}</button>   
                                    
                                @endif
                            </div>
                        </div>
                    </form>                     
                </div>
            </section>
        </div>
    </div>
</section>
@endsection
@section('foot_page')

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

<!-- <script type="text/javascript" src="{{ asset('assets/admin/vendor/tinymce/tinymce.min.js') }}">       </script> -->
<script>
    $(document).ready(function() {
        $('.select2').select2();
        
        // tinymce.init({
        //     selector: "textarea.textarea",
        //     setup: function (editor) {
        //         editor.on('keyup', function () {
        //             var content = editor.getContent();
        //             document.getElementById('hideDescription').value = content;
        //         });
        //     },
            
        //     menubar: false,
        //     height: 300,
        //     resize:false,
        //     convert_urls: false,
        //     @isset($disabled)
        //                 readonly : 1,
        //             @endisset
        //     // extended_valid_elements : "a[class|name|href|target|title|onclick|rel],script[type|src],iframe[src|style|width|height|scrolling|marginwidth|marginheight|frameborder],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name]",
        //     plugins: [
        //         "textcolor",
        //         "advlist autolink lists link image charmap print preview anchor",
        //         "searchreplace visualblocks code fullscreen",
        //         "insertdatetime media table paste hr",
        //         "wordcount fullscreen nonbreaking visualblocks",
        //     ],
        //     content_css: [
        //         {{--
        //         // Ponemos aquí los css de front
        //         '{{ url('assets/front/vendor/bootstrap/css/bootstrap.min.css') }}',
        //         '{{ url('assets/front/vendor/fontawesome/css/font-awesome.min.css') }}',
        //         '{{ url('assets/front/css/front.min.css') }}',
        //         '{{ url('assets/front/css/theme.css') }}',
        //         '{{ url('assets/front/css/theme-element.css') }}',
        //         '{{ url('assets/front/vendor/fontawesome/css/font-awesome.min.css') }}'
        //         --}}
        //         ],
        //     toolbar: "forecolor backcolor | insertfile undo redo | styleselect | fontsizeselect | bold italic forecolor, backcolor | hr nonbreaking visualblocks | table |  alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link media image | code fullscreen",
        //     file_picker_callback: function(callback, value, meta) {
        //         openImageControllerExt(callback, '0');
        //     }
        // });
    });

</script>

{!! JsValidator::formRequest('App\Http\Requests\AdminMunicipioRequest')->selector('#formData') !!}
@stop

