@extends('layouts.emails.user')

@section('content')

    <div>
        <p>
            Dear {{$user->name}},
        </p>
        <p>
            We regret to inform you that your account on {{config('app.name')}} has been temporarily suspended due to unusual
            activities. This suspension is effective immediately and restricts your access to all services and features
            of our web app.
        </p>
        <p>
            To resolve this issue and reactivate your account, please contact our support team as soon as possible. You
            can reach us at <a href="mailto:support@ttavenue.com">support@ttavenue.com</a>.
        </p>
        <p>
            We apologize for any inconvenience this may cause and appreciate your prompt attention to this matter. Our
            goal is to ensure the security and integrity of our platform for all users. <br> <br>
            Thank you for your understanding and cooperation.
        </p>
    </div>

@endsection
