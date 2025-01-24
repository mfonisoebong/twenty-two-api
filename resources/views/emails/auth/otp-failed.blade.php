@extends('layouts.emails.user', ['excludeFooter'=> true])

@section('content')
    <div style="width: max-content; margin-left: auto; margin-right: auto">
        <h3 style="text-align: center">Email verification failed</h3>

        <p>
            The verification link has expired or invalid.
        </p>

    </div>

@endsection
