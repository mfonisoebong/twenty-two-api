@extends('layouts.emails.user')

@section('content')

    <div>
        <p>
            Hi {{$invoice->user->name}},
        </p>
        <p>
            This to inform you that your Dex order # {{$invoice->id}} has been cancelled!
        </p>
        <p>
           If you have any questions please contact our support team via <a
                href="mailto:support@dexwearsglobal.com">support@dexwearsglobal.com</a>. Thank you as you comply.
        </p>
    </div>

    <div>
       
        <p>
            Need Help?
        </p>
        <p>
            If you have any questions about your order or need assistance with anything, please don't hesitate to
            contact our customer support team at <a
                href="mailto:support@dexwearsglobal.com">support@dexwearsglobal.com</a>.
        </p>
   
    </div>

@endsection
