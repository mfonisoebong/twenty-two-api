@extends('layouts.emails.user')

@section('content')

    @if($otp->type === 'email_verification')

        <div>
            <p>Hi {{$otp->user->full_name}},</p>
            <p>
                Thank you for signing up with {{config('app.name')}}! To complete your account creation, please click on the
                link below to verify your email address:
            </p>
            <p>
                <a href="{{route('verify-account', $otp->code)}}">{{route('verify-account', $otp->code)}}</a>
            </p>
            <p>
                This code is valid for 15 minutes.
            </p>
            <p>
                <b>Important</b>: For security reasons, please do not share this OTP with anyone.
            </p>
            <p>
                Once you've entered the OTP, you'll be able to access your {{config('app.name')}} account and explore all the
                features we offer.
            </p>
        </div>

    @else

        <div>
            <p>Hi {{$otp->user->full_name}},</p>
            <p>
                You have requested to reset your password. Please enter the following 4-digit One-Time Password (OTP) to
                reset your password:
            </p>
            <h3 style="text-align: center; font-size: 24px">{{$otp->code}}</h3>
            <p>
                This code is valid for 15 minutes.
            </p>
            <p>
                <b>Important</b>: For security reasons, please do not share this OTP with anyone.
            </p>
            <p>
                If you did not request to reset your password, please ignore this email.
            </p>
        </div>

    @endif

@endsection
