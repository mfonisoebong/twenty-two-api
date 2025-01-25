@extends('layouts.emails.user')

@section('content')

    <div>
        <p>
            Dear {{$user->name}},
        </p>
        <p>
            We are pleased to inform you that your account on {{config('app.name')}} has been successfully reactivated. You can
            now access all the services and features of our web app without any restrictions.
        </p>
        <p>
            If you have any questions or need further assistance, please do not hesitate to reach out to our support
            team at <a href="mailto:support@ttavenue.com">support@ttavenue.com</a>. We are here to help you
            with any concerns you may have.
        </p>
        <p>
            Thank you for your cooperation and understanding. We appreciate your continued trust in Dex.
            <br> <br>
            <b>Welcome back!</b>
        </p>
    </div>

@endsection
