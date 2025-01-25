@extends('layouts.emails.admin')

@section('content')

    <div>
        <p>Hi {{$user->name}},</p>
        <p>
            Welcome to the {{config('app.name')}} family! We're thrilled to have you on board.
            {{config('app.name')}} is a one-stop shop for all prescription needs. With our user-friendly website, you
            can:
        </p>
        <p>
            <b>Email:</b> {{$user->email}} <br>
            <b>Password:</b> {{$password}}
        </p>
        <p>
            <b>Please do not share this with anybody!</b>
        </p>

        <p>
            In order to access your admin dashboard, here are your admin credentials
        </p>
        <p>
            Welcome onboard!
        </p>

    </div>

@endsection
