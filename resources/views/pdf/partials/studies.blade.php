@extends('pdf.general_layout')




@section('content')
@php
$medicalStudies =$info;
@endphp
<div style="border: 1px solid black; margin-top:10px; padding:20px;">
   
   

      <b><i>{{ trans("pdfLayout/admin_studies_lang.do_studies") }}</i></b>
      <span style="padding-left:15px;">
        {!! $medicalStudies->description !!}
        
    </span>
</div>

@endsection
