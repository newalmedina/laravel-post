@extends('pdf.general_layout')




@section('content')
@php
$medicine =$info;
@endphp
<div style="border: 1px solid black; margin-top:10px; padding:20px;">
    <ul>
        @foreach ($medicine->details as $detail)
        <li>{{ $detail->prescripcionString }}</li>
        @endforeach
    </ul>
    <br>
    @if (!empty($medicine->comment ))
    <b><i>{{ trans("pdfLayout/admin_recetas_lang.comments") }}</i></b>
      <span style="padding-left:15px;">
        {!! $medicine->comment !!}
        
    </span>
    @endif
</div>

@endsection
