@extends('layouts.emails.user')

@section('content')
    <div>
        <p>Hi {{$user->full_name}},</p>
        <p>
            Thanks for joining the {{config('app.name')}} family! We're thrilled to have you on board.
            {{config('app.name')}} is your one-stop shop for all your prescription needs. With our user-friendly website, you
            can:
        </p>


        <p>
            <b>We're Here to Help!</b>
        </p>
        <p>
            If you have any questions or need assistance, please don't hesitate to contact our friendly customer support
            team at <a href="mailto:support@ttavenue.com">support@ttavenue.com</a>.
        </p>
        <p>
            We're committed to providing you with a convenient and reliable shopping experience.
            <br>
            Welcome aboard!
        </p>
    </div>
@endsection
