@extends('layouts.emails.user')

@section('content')

    <div>
        <p>
            Hi {{$invoice->user->name}},
        </p>
        <p>
            We're happy to inform you that your Dex order # {{$invoice->id}} has been delivered!
        </p>
        <p>
            We hope you're happy with your purchase!
            <br>
            Next Steps:
        </p>
    </div>

    <div>
        <ul>
            <li>Review your order: Feel free to log in to your Dex account to view your order details and
                manage your past purchases.
            </li>
            <li>
                Leave a review: We appreciate your feedback! Let us know about your experience with Dex by
                leaving a review on the product pages of the items you purchased.
            </li>
        </ul>

        <p>
            Need Help?
        </p>
        <p>
            If you have any questions about your order or need assistance with anything, please don't hesitate to
            contact our customer support team at <a
                href="mailto:support@dexwearsglobal.com">support@dexwearsglobal.com</a>.
        </p>
        <p>
            We're here to help!
            <br>
            Thank you for choosing Dex!
        </p>
    </div>

@endsection
