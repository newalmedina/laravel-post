

@extends('layouts.front.default_emails')

@section('head_page')


@stop
@section('content')

 <p>{!! trans('emails/general_lang.greatings_name',["name"=>$reciever->UserProfile->fullName]) !!}</p>
 
 <p>{!! trans('emails/other_user_created_lang.text_1',["plataformaName"=>  $setting->site_name]) !!}</p>

 <p>{!! trans('emails/other_user_created_lang.name') !!}<b>{!!$userCreated->userProfile->fullName!!}</b></p>
 <p>{!! trans('emails/other_user_created_lang.email') !!}<b>{!!$userCreated->email!!}</b></p>
 <p>{!! trans('emails/other_user_created_lang.center_created') !!}<b>{!!$center->name!!}</b></p>

 <p>{!! trans('emails/other_user_created_lang.text_2') !!}</p>


<br/>
 <p>{!! trans('emails/general_lang.bye') !!}  {!!$setting->site_name!!}
     

 
@endsection

@section('foot_page')
@stop