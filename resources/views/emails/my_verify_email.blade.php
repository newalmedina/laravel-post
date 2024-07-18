

@extends('layouts.front.default_emails')

@section('head_page')


@stop
 @php
                    $settingInsideMessage =\App\Services\SettingsServices::getGeneral();
            @endphp
@section('content')
 <p>{!! trans('emails/general_lang.greatings_name',["name"=>$reciever->UserProfile->fullName]) !!}</p>
 
 <p>{!! trans('emails/my_verify_email_lang.text_1',["plataformaName"=>$settingInsideMessage->site_name]) !!}</p>

 <a class="btn btn-primary" href="{!!$url!!}" target="_blank" >{!! trans('emails/my_verify_email_lang.verify_btn') !!}</a>

<br/>
<p>{{ trans('emails/my_reset_password_lang.text_2') }}</p>ol

 <p>{!! trans('emails/my_verify_email_lang.text_3') !!}</p>
<br/>
 <p>{!! trans('emails/general_lang.bye') !!}  {!!$settingInsideMessage->site_name!!}
     
<br/>
 <p>{!! trans('emails/my_verify_email_lang.text_4') !!} <a href="{!!$url!!}" target="_blank">{!!$url!!}</a></p>
 

 
@endsection

@section('foot_page')
@stop