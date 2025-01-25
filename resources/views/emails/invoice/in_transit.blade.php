@extends('layouts.emails.user')

@section('content')
    <div>
        <p>
            Hi {{$invoice->user->name}},
        </p>
        <p>
            Great news! Your {{config('app.name')}} order # {{$invoice->id}} has shipped and is now on its way to you.
        </p>
        <p>
            Estimated Delivery:
            <br>
            Your order is expected to be delivered in 24-72 hours. However, please note that this is an estimate and
            delivery times may vary.
        </p>
    </div>

    <div>
        <p>Questions?</p>
        <p>
            If you have any questions about your order or its delivery, please don't hesitate to contact our customer
            support team at <a href="mailto:support@ttavenue.com">support@ttavenue.com</a>.
        </p>
        <p>
            We're here to help! <br>
            We look forward to getting your order to you soon!
        </p>
    </div>

@endsection
