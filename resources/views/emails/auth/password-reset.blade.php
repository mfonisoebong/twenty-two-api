@extends('layouts.emails.user')

@section('content')
    <div>
        <p>Hi {{$user->name}},</p>
        <p>
            This email confirms that your password has been successfully reset. You can now log in to your
            account using your new password.
        </p>
        <p>
            Here's a friendly reminder:
        </p>
        <p>
            Keep your new password secure and avoid sharing it with anyone. <br>
            Consider using a strong password that combines uppercase and lowercase letters, numbers, and symbols. <br>
            We're happy to have you back in the {{config('app.name')}} crew!
        </p>


        <p>
            <b>Happy shopping!</b>
        </p>

    </div>
@endsection
