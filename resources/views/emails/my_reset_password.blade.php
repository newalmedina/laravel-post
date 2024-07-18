

@extends('layouts.front.default_emails')

@section('head_page')


@stop
 @php
                    $settingInsideMessage =\App\Services\SettingsServices::getGeneral();
            @endphp
@section('content')
 <p>{{ trans('emails/general_lang.greatings') }}</p>
 
 <p>{{ trans('emails/my_reset_password_lang.text_1') }}</p>

 <a class="btn btn-primary" href="{{ route('password.reset', $token)}}" target="_blank" >{{ trans('emails/my_reset_password_lang.recovery_btn') }}</a>

<br/>
 <p>{{ trans('emails/my_reset_password_lang.text_2') }}</p>
 <p>{{ trans('emails/my_reset_password_lang.text_3') }}</p>
<br/>
 <p>{{ trans('emails/general_lang.bye') }}  {{$settingInsideMessage->site_name}}
     
<br/>
 <p>{{ trans('emails/my_reset_password_lang.text_4') }} <a href="{{ route('password.reset', $token)}}" target="_blank">{{ route('password.reset', $token)}}</a></p>
 

 
@endsection

@section('foot_page')
@stop