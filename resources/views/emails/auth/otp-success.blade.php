@extends('layouts.emails.user', ['excludeFooter'=> true])

@section('content')

    <div style="width: max-content; margin-left: auto; margin-right: auto">
        <h3 style="text-align: center">Email verified successfly</h3>

        <p>
            Your email has been successfully verified. You can now access your {{config('app.name')}} account and
            explore all
            the
            features we offer.
        </p>
        <p> Go to
            <a target="_blank" href="{{config('app.client_url')}}">homepage</a>
        </p>
    </div>

@endsection
