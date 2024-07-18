

@extends('layouts.front.default_emails')

@section('head_page')


@stop
@section('content')

 <p>{!! trans('emails/general_lang.greatings_name',["name"=>$userCreated->UserProfile->fullName]) !!}</p>
 
 <p>{!! trans('emails/user_created_lang.text_1') !!}</p>

 <p>{!! trans('emails/user_created_lang.email') !!} <b>{!!$userCreated->email!!}</b></p>
 <p>{!! trans('emails/user_created_lang.password') !!}<b>{!!$password!!}</b></p>



<br/>
 <p>{!! trans('emails/general_lang.bye') !!}  {!!$setting->site_name!!}
     

 
@endsection

@section('foot_page')
@stop